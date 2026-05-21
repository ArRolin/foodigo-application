<?php

namespace App\Http\Controllers\Api\Frontend\Auth;

use Str;
use Hash;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Modules\GlobalSetting\App\Models\GlobalSetting;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;
use App\Mail\ApiUserRegistrationMail;

class AuthController extends BaseController
{
    /**
     * User login
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return $this->sendError('Email not found', [], 404);
            }

            if (!Hash::check($request->password, $user->password)) {
                return $this->sendError('Invalid credentials', [], 401);
            }

            if ($user->email_verified_at == null) {
                return $this->sendError('Please verify your email', [], 401);
            }

            if ($user->status !== 'enable') {
                return $this->sendError('Your account is inactive', [], 401);
            }

            if ($user->is_banned == 'enable') {
                return $this->sendError('Your account is banned', [], 401);
            }

            // Create API token
            $token = $user->createToken('api-token')->plainTextToken;

            $data = [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'username' => $user->username,
                    'phone' => $user->phone,
                    'image' => $user->image,
                    'address' => $user->address,
                    'status' => $user->status,
                ],
                'token' => $token,
                'token_type' => 'Bearer'
            ];

            return $this->sendResponse($data, 'Login successful');

        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * User registration
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        // try {
            $verificationToken = Str::random(100);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'status' => 'enable',
                'is_banned' => 'disable',
                'verification_token' => $verificationToken,
            ]);

            // Send verification email
            $this->sendVerificationEmail($user);

            $data = [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ]
            ];

            return $this->sendResponse($data, 'Registration successful. Please check your email for OTP');

        // } catch (\Exception $e) {
        //     Log::error('Registration error: ' . $e->getMessage());
        //     return $this->sendError('Something went wrong', [], 500);
        // }
    }

    /**
     * User logout
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return $this->sendResponse([], 'Logout successful');

        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Get authenticated user profile
     */
    public function profile(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $data = [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'username' => $user->username,
                    'phone' => $user->phone,
                    'image' => $user->image,
                    'status' => $user->status,
                    'address' => $user->address,
                    'email_verified_at' => $user->email_verified_at,
                ]
            ];

            return $this->sendResponse($data, 'Profile retrieved successfully');

        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->user()->id,
            'phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $user = $request->user();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($user->image && file_exists(public_path($user->image))) {
                    unlink(public_path($user->image));
                }

                $image = $request->file('image');
                $imageName = time() . '.' . $image->extension();
                $image->move(public_path('uploads/users'), $imageName);
                $user->image = 'uploads/users/' . $imageName;
            }

            $user->save();

            $data = [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'image' => $user->image,
                    'status' => $user->status,
                    'address' => $user->address,
                ]
            ];

            return $this->sendResponse($data, 'Profile updated successfully');

        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Change password
     */
    public function changePassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $user = $request->user();

            if (!Hash::check($request->current_password, $user->password)) {
                return $this->sendError('Current password is incorrect', [], 400);
            }

            $user->password = Hash::make($request->password);
            $user->save();

            return $this->sendResponse([], 'Password changed successfully');

        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Send password reset email
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return $this->sendError('Email not found', [], 404);
            }

            // Send password reset email
            $this->sendVerificationEmail($user);

            return $this->sendResponse([], 'OTP sent successfully in Your Email');

        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Reset password
     */
public function resetPassword(Request $request): JsonResponse
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'otp' => 'required|string|size:6',
        'password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return $this->sendValidationError($validator->errors()->toArray());
    }

    // try {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->sendError('User not found', [], 404);
        }

        // Find the OTP
        $otpRecord = UserOtp::where('user_id', $user->id)
            ->where('otp', $request->otp)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otpRecord) {
            return $this->sendError('Invalid or expired OTP', [], 400);
        }

        // Mark OTP as used
        $otpRecord->used = true;
        $otpRecord->save();

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return $this->sendResponse([], 'Password reset successfully');

    // } catch (\Exception $e) {
    //     return $this->sendError('Something went wrong', [], 500);
    // }
}

    /**
     * Verify email with OTP
     */
    public function verifyEmail(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return $this->sendError('User not found', [], 404);
            }

            if ($user->email_verified_at) {
                return $this->sendError('Email already verified', [], 400);
            }

            // Find the OTP
            $otpRecord = UserOtp::where('user_id', $user->id)
                ->where('otp', $request->otp)
                ->where('type', 'email_verification')
                ->where('used', false)
                ->where('expires_at', '>', now())
                ->first();

            if (!$otpRecord) {
                return $this->sendError('Invalid or expired OTP', [], 400);
            }

            // Mark OTP as used
            $otpRecord->used = true;
            $otpRecord->save();

            // Verify user email
            $user->email_verified_at = now();
            $user->verification_token = null;
            $user->save();

            $data = [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                ]
            ];

            return $this->sendResponse($data, 'Email verified successfully');

        } catch (\Exception $e) {
            Log::error('Email verification error: ' . $e->getMessage());
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Resend verification email
     */
    public function resendVerificationEmail(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return $this->sendError('Email not found', [], 404);
            }

            if ($user->email_verified_at) {
                return $this->sendError('Email already verified', [], 400);
            }

            $this->sendVerificationEmail($user);

            return $this->sendResponse([], 'Verification OTP sent successfully in Your Email');

        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Send OTP verification email
     */
    private function sendVerificationEmail($user)
    {
        // try {
            // Delete old unused OTPs for this user and type
            UserOtp::where('user_id', $user->id)
                ->where('type', 'email_verification')
                ->where('used', false)
                ->delete();

            // Generate new OTP
            $otp = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
            $expiryMinutes = 15; // OTP expires in 15 minutes

            // Store OTP in database
            UserOtp::create([
                'user_id' => $user->id,
                'otp' => $otp,
                'type' => 'email_verification',
                'expires_at' => Carbon::now()->addMinutes($expiryMinutes),
                'used' => false,
            ]);

            // Send email with OTP
            $emailData = [
                'user' => $user,
                'otp' => $otp,
                'expiryMinutes' => $expiryMinutes,
            ];

            

            $subject = 'Email Verification - ' . config('app.name');
            $message = $emailData;
            Mail::to($user->email)->send(new ApiUserRegistrationMail($message, $subject, $user));

            Log::info('OTP verification email sent to: ' . $user->email);

        // } catch (\Exception $e) {
        //     Log::error('Error sending verification email: ' . $e->getMessage());
        //     throw $e;
        // }
    }

    /**
     * Check OTP status - helper method
     */
    public function checkOtpStatus(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return $this->sendError('User not found', [], 404);
            }

            $latestOtp = $user->getLatestOtp('email_verification');

            $data = [
                'has_active_otp' => $latestOtp ? true : false,
                'otp_expires_at' => $latestOtp ? $latestOtp->expires_at->toISOString() : null,
                'time_remaining' => $latestOtp ? max(0, $latestOtp->expires_at->diffInMinutes(now())) : 0,
                'can_resend' => !$latestOtp || $latestOtp->expires_at->isPast(),
                'email_verified' => $user->email_verified_at ? true : false,
            ];

            return $this->sendResponse($data, 'OTP status retrieved successfully');

        } catch (\Exception $e) {
            Log::error('Check OTP status error: ' . $e->getMessage());
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Generate and send new OTP
     */
    public function generateNewOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return $this->sendError('User not found', [], 404);
            }

            if ($user->email_verified_at) {
                return $this->sendError('Email already verified', [], 400);
            }

            // Check if user can request new OTP (rate limiting)
            $lastOtp = UserOtp::where('user_id', $user->id)
                ->where('type', 'email_verification')
                ->latest()
                ->first();

            if ($lastOtp && $lastOtp->created_at->diffInMinutes(now()) < 2) {
                return $this->sendError('Please wait before requesting a new OTP. You can request a new OTP every 2 minutes.', [], 429);
            }

            // Send new OTP
            $this->sendVerificationEmail($user);

            $data = [
                'message' => 'A new OTP has been sent to your email address',
                'email' => $user->email,
                'expires_in_minutes' => 15
            ];

            return $this->sendResponse($data, 'New OTP sent successfully');

        } catch (\Exception $e) {
            Log::error('Generate new OTP error: ' . $e->getMessage());
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Clean expired OTPs - can be called via cron job
     */
    public function cleanExpiredOtps(): JsonResponse
    {
        try {
            $deletedCount = UserOtp::where('expires_at', '<', now())
                ->orWhere('used', true)
                ->delete();

            Log::info('Cleaned up expired OTPs: ' . $deletedCount . ' records deleted');

            return $this->sendResponse([
                'deleted_count' => $deletedCount
            ], 'Expired OTPs cleaned successfully');

        } catch (\Exception $e) {
            Log::error('Clean expired OTPs error: ' . $e->getMessage());
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Send password reset email
     */
    private function sendPasswordResetEmail($user)
    {
        // Implementation for sending password reset email
        // This would typically use Laravel's Mail facade
        // Mail::to($user->email)->send(new PasswordResetEmail($user));
    }
    
     public function reset_otp_match(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'string', 'size:6'],
        ],[
            'email.required' => trans('translate.Email is required'),
            'otp.required' => trans('translate.OTP is required'),
            'otp.string' => trans('translate.OTP must be a string'),
            'otp.size' => trans('translate.OTP must be 6 characters'),
        ]);

        $user = User::where('email', $request->email)->first();
        $otpRecord = UserOtp::where('user_id', $user->id)
            ->where('otp', $request->otp)
            ->where('used', false)
            ->first();
        if($otpRecord){
            return $this->sendResponse([], 'OTP matched successfully');

        }else{
            return $this->sendError('Invalid OTP, please try again', [], 400);
        }

        

    }
}
