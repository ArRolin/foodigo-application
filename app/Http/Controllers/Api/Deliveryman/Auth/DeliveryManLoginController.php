<?php

namespace App\Http\Controllers\Api\DeliveryMan\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Models\DeliveryMan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DeliveryManLoginController extends BaseController
{
    /**
     * Delivery man login
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
            $deliveryMan = DeliveryMan::where('email', $request->email)->first();

            if (!$deliveryMan) {
                return $this->sendError('Email not found', [], 404);
            }

            if (!$deliveryMan->is_email_verified) {
                return $this->sendError('Please verify your email first', [], 401);
            }

            if (!$deliveryMan->password) {
                return $this->sendError('Please complete your registration by setting a password', [], 401);
            }

            if (!Hash::check($request->password, $deliveryMan->password)) {
                return $this->sendError('Invalid credentials', [], 401);
            }

            if ($deliveryMan->status != 1) {
                return $this->sendError('Your account is inactive or pending approval', [], 401);
            }

            $token = $deliveryMan->createToken('deliveryman-api-token')->plainTextToken;

            $data = [
                'delivery_man' => [
                    'id' => $deliveryMan->id,
                    'fname' => $deliveryMan->fname,
                    'lname' => $deliveryMan->lname,
                    'email' => $deliveryMan->email,
                    'phone' => $deliveryMan->phone,
                    'profile_image' => $deliveryMan->profile_image,
                    'address' => $deliveryMan->address,
                    'status' => $deliveryMan->status,
                    'is_email_verified' => $deliveryMan->is_email_verified,
                ],
                'token' => $token,
                'token_type' => 'Bearer'
            ];

            return $this->sendResponse($data, 'Login successful');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Logout
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
     * Step 1: Basic Information
     */
    public function registerStepOne(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female,other',
            'country_code' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:delivery_men,email',
            'date_of_birth' => 'required|date|before:today',
            'city_id' => 'required|integer',
            'zip_code' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $data = [
                'fname' => $request->fname,
                'lname' => $request->lname,
                'gender' => $request->gender,
                'country_code' => $request->country_code,
                'phone' => $request->phone,
                'email' => $request->email,
                'date_of_birth' => $request->date_of_birth,
                'city_id' => $request->city_id,
                'zip_code' => $request->zip_code,
                'address' => $request->address,
            ];

            return $this->sendResponse($data, 'Step 1 completed successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Step 2: Document Information
     */
    public function registerStepTwo(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'document_type_id' => 'required|string|max:50',
            'document_number' => 'required|string|max:100',
            'profile_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'document' => 'required|image|mimes:jpg,jpeg,png,webp,pdf|max:2048',
            'short_note' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $profile_image_path = null;
            $document_path = null;

            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                $profile_image = $request->file('profile_image');
                $profile_image_name = 'profile_' . time() . '_' . Str::random(10) . '.' . $profile_image->getClientOriginalExtension();
                $profile_image->move(public_path('uploads/deliveryman/profile_images'), $profile_image_name);
                $profile_image_path = 'uploads/deliveryman/profile_images/' . $profile_image_name;
            }

            // Handle document upload
            if ($request->hasFile('document')) {
                $document = $request->file('document');
                $document_name = 'doc_' . time() . '_' . Str::random(10) . '.' . $document->getClientOriginalExtension();
                $document->move(public_path('uploads/deliveryman/documents'), $document_name);
                $document_path = 'uploads/deliveryman/documents/' . $document_name;
            }

            $data = [
                'document_type_id' => $request->document_type_id,
                'document_number' => $request->document_number,
                'profile_image' => $profile_image_path,
                'document' => $document_path,
                'short_note' => $request->short_note ?? null,
            ];

            return $this->sendResponse($data, 'Step 2 completed successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Step 3: Vehicle Information & Complete Registration (Save all data & send OTP)
     */
    public function registerStepThree(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            // Step 3 fields
            'vehicle_type_id' => 'required|string|max:50',
            'vehicle_number' => 'required|string|max:50',
            'vehicle_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            
            // All previous step fields (they should be sent again)
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female,other',
            'country_code' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:delivery_men,email',
            'date_of_birth' => 'required|date|before:today',
            'city_id' => 'required|integer',
            'zip_code' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'document_type_id' => 'required|string|max:50',
            'document_number' => 'required|string|max:100',
            'profile_image' => 'required|string', // Path from step 2
            'document' => 'required|string', // Path from step 2
            'short_note' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $vehicle_image_path = null;

            // Handle vehicle image upload
            if ($request->hasFile('vehicle_image')) {
                $vehicle_image = $request->file('vehicle_image');
                $vehicle_image_name = 'vehicle_' . time() . '_' . Str::random(10) . '.' . $vehicle_image->getClientOriginalExtension();
                $vehicle_image->move(public_path('uploads/deliveryman/vehicle_images'), $vehicle_image_name);
                $vehicle_image_path = 'uploads/deliveryman/vehicle_images/' . $vehicle_image_name;
            }

            // Generate OTP
            $otp = rand(100000, 999999);
            $otp_expires_at = Carbon::now()->addMinutes(10);

            // Create delivery man record
            $deliveryMan = DeliveryMan::create([
                // Step 1 data
                'fname' => $request->fname,
                'lname' => $request->lname,
                'gender' => $request->gender,
                'country_code' => $request->country_code,
                'phone' => $request->phone,
                'email' => $request->email,
                'date_of_birth' => $request->date_of_birth,
                'city_id' => $request->city_id,
                'zip_code' => $request->zip_code,
                'address' => $request->address,
                
                // Step 2 data
                'document_type_id' => $request->document_type_id,
                'document_number' => $request->document_number,
                'profile_image' => $request->profile_image,
                'document' => $request->document,
                'short_note' => $request->short_note,
                
                // Step 3 data
                'vehicle_type_id' => $request->vehicle_type_id,
                'vehicle_number' => $request->vehicle_number,
                'vehicle_image' => $vehicle_image_path,
                
                // OTP & verification
                'otp' => $otp,
                'otp_expires_at' => $otp_expires_at,
                'is_email_verified' => false,
                'status' => 0, // Pending
            ]);

            // Send OTP via email
            $this->sendOtpEmail($deliveryMan, $otp);

            $data = [
                'delivery_man_id' => $deliveryMan->id,
                'email' => $deliveryMan->email,
                'message' => 'Registration successful! Please check your email for OTP verification code.',
            ];

            return $this->sendResponse($data, 'Registration completed! OTP sent to your email');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $deliveryMan = DeliveryMan::where('email', $request->email)->first();

            if (!$deliveryMan) {
                return $this->sendError('Delivery man not found', [], 404);
            }

            if ($deliveryMan->is_email_verified) {
                return $this->sendError('Email already verified', [], 400);
            }

            if ($deliveryMan->otp != $request->otp) {
                return $this->sendError('Invalid OTP', [], 400);
            }

            if (Carbon::now()->greaterThan($deliveryMan->otp_expires_at)) {
                return $this->sendError('OTP has expired. Please request a new one', [], 400);
            }

            // Mark as verified
            $deliveryMan->update([
                'is_email_verified' => true,
                'otp' => null,
                'otp_expires_at' => null,
            ]);

            $data = [
                'delivery_man_id' => $deliveryMan->id,
                'email' => $deliveryMan->email,
                'is_verified' => true,
                'message' => 'Email verified successfully! Now please set your password.',
            ];

            return $this->sendResponse($data, 'OTP verified successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Resend OTP
     */
    public function resendOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $deliveryMan = DeliveryMan::where('email', $request->email)->first();

            if (!$deliveryMan) {
                return $this->sendError('Delivery man not found', [], 404);
            }

            if ($deliveryMan->is_email_verified) {
                return $this->sendError('Email already verified', [], 400);
            }

            // Generate new OTP
            $otp = rand(100000, 999999);
            $otp_expires_at = Carbon::now()->addMinutes(10);

            $deliveryMan->update([
                'otp' => $otp,
                'otp_expires_at' => $otp_expires_at,
            ]);

            // Send OTP via email
            $this->sendOtpEmail($deliveryMan, $otp);

            return $this->sendResponse([], 'OTP has been resent to your email');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Set Password (after OTP verification)
     */
    public function setPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:4|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $deliveryMan = DeliveryMan::where('email', $request->email)->first();

            if (!$deliveryMan) {
                return $this->sendError('Delivery man not found', [], 404);
            }

            if (!$deliveryMan->is_email_verified) {
                return $this->sendError('Please verify your email first', [], 400);
            }

            if ($deliveryMan->password) {
                return $this->sendError('Password already set. Please login', [], 400);
            }

            // Set password
            $deliveryMan->update([
                'password' => Hash::make($request->password),
            ]);

            $data = [
                'delivery_man_id' => $deliveryMan->id,
                'email' => $deliveryMan->email,
                'message' => 'Password set successfully! You can now login.',
            ];

            return $this->sendResponse($data, 'Password set successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Send OTP via email
     */
    private function sendOtpEmail($deliveryMan, $otp)
    {
        try {
            $fullName = $deliveryMan->fname . ' ' . $deliveryMan->lname;
            $subject = 'Delivery Man Registration - OTP Verification';
            $message = "
                <h2>Welcome to our Delivery Service!</h2>
                <p>Dear {$fullName},</p>
                <p>Your OTP for email verification is: <strong style='font-size: 24px; color: #4CAF50;'>{$otp}</strong></p>
                <p>This OTP will expire in 10 minutes.</p>
                <p>If you did not register, please ignore this email.</p>
                <br>
                <p>Best regards,<br>Delivery Team</p>
            ";

            Mail::send([], [], function ($mail) use ($deliveryMan, $subject, $message) {
                $mail->to($deliveryMan->email)
                    ->subject($subject)
                    ->html($message);
            });
        } catch (\Exception $e) {
            // Log error but don't stop the process
            \Log::error('OTP Email Error: ' . $e->getMessage());
        }
    }

    /**
     * Get Profile
     */
    public function profile(Request $request): JsonResponse
    {
        try {
            $deliveryMan = $request->user();

            $data = [
                'id' => $deliveryMan->id,
                'fname' => $deliveryMan->fname,
                'lname' => $deliveryMan->lname,
                'email' => $deliveryMan->email,
                'phone' => $deliveryMan->phone,
                'gender' => $deliveryMan->gender,
                'date_of_birth' => $deliveryMan->date_of_birth,
                'address' => $deliveryMan->address,
                'city_id' => $deliveryMan->city_id,
                'zip_code' => $deliveryMan->zip_code,
                'profile_image' => $deliveryMan->profile_image,
                'vehicle_number' => $deliveryMan->vehicle_number,
                'status' => $deliveryMan->status,
                'is_email_verified' => $deliveryMan->is_email_verified,
            ];

            return $this->sendResponse($data, 'Profile retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }

    /**
     * Forgot Password - Send OTP to email
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
            $deliveryMan = DeliveryMan::where('email', $request->email)->first();

            if (!$deliveryMan) {
                return $this->sendError('Email not found', [], 404);
            }

            // Generate OTP for password reset
            $otp = rand(100000, 999999);
            $otp_expires_at = Carbon::now()->addMinutes(10);

            $deliveryMan->update([
                'otp' => $otp,
                'otp_expires_at' => $otp_expires_at,
            ]);

            // Send OTP via email
            $this->sendPasswordResetOtpEmail($deliveryMan, $otp);

            return $this->sendResponse([
                'email' => $deliveryMan->email,
                'message' => 'OTP has been sent to your email'
            ], 'Password reset OTP sent successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Verify OTP for Password Reset
     */
    public function verifyResetOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $deliveryMan = DeliveryMan::where('email', $request->email)->first();

            if (!$deliveryMan) {
                return $this->sendError('Delivery man not found', [], 404);
            }

            if ($deliveryMan->otp != $request->otp) {
                return $this->sendError('Invalid OTP', [], 400);
            }

            if (Carbon::now()->greaterThan($deliveryMan->otp_expires_at)) {
                return $this->sendError('OTP has expired. Please request a new one', [], 400);
            }

            // OTP is valid
            $data = [
                'email' => $deliveryMan->email,
                'otp_verified' => true,
                'message' => 'OTP verified successfully! Now you can reset your password.',
            ];

            return $this->sendResponse($data, 'OTP verified successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Reset Password (after OTP verification)
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
            'password' => 'required|string|min:4|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $deliveryMan = DeliveryMan::where('email', $request->email)->first();

            if (!$deliveryMan) {
                return $this->sendError('Delivery man not found', [], 404);
            }

            // Verify OTP again before resetting password
            if ($deliveryMan->otp != $request->otp) {
                return $this->sendError('Invalid OTP', [], 400);
            }

            if (Carbon::now()->greaterThan($deliveryMan->otp_expires_at)) {
                return $this->sendError('OTP has expired. Please request a new one', [], 400);
            }

            // Reset password
            $deliveryMan->update([
                'password' => Hash::make($request->password),
                'otp' => null,
                'otp_expires_at' => null,
            ]);

            $data = [
                'email' => $deliveryMan->email,
                'message' => 'Password has been reset successfully! You can now login with your new password.',
            ];

            return $this->sendResponse($data, 'Password reset successful');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Change Password (for logged in users)
     */
    public function changePassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:4|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors()->toArray());
        }

        try {
            $deliveryMan = $request->user();

            // Check current password
            if (!Hash::check($request->current_password, $deliveryMan->password)) {
                return $this->sendError('Current password is incorrect', [], 400);
            }

            // Update password
            $deliveryMan->update([
                'password' => Hash::make($request->new_password),
            ]);

            return $this->sendResponse([], 'Password changed successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong: ' . $e->getMessage(), [], 500);
        }
    }

    /**
     * Send Password Reset OTP via email
     */
    private function sendPasswordResetOtpEmail($deliveryMan, $otp)
    {
        try {
            $fullName = $deliveryMan->fname . ' ' . $deliveryMan->lname;
            $subject = 'Password Reset - OTP Verification';
            $message = "
                <h2>Password Reset Request</h2>
                <p>Dear {$fullName},</p>
                <p>You have requested to reset your password. Your OTP for password reset is:</p>
                <p><strong style='font-size: 24px; color: #FF5722;'>{$otp}</strong></p>
                <p>This OTP will expire in 10 minutes.</p>
                <p>If you did not request a password reset, please ignore this email and your password will remain unchanged.</p>
                <br>
                <p>Best regards,<br>Delivery Team</p>
            ";

            Mail::send([], [], function ($mail) use ($deliveryMan, $subject, $message) {
                $mail->to($deliveryMan->email)
                    ->subject($subject)
                    ->html($message);
            });
        } catch (\Exception $e) {
            // Log error but don't stop the process
            \Log::error('Password Reset OTP Email Error: ' . $e->getMessage());
        }
    }
}
