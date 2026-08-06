<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Actions\Fortify\PasswordValidationRules;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateUser extends Command
{
    use PasswordValidationRules;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create
                            {--name= : The new user name}
                            {--email= : The new user email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user account';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->option('name');
        if ($name === null) {
            $name = text(
                label: 'Enter the new user name',
                required: true
            );
        }
        $email = $this->option('email');
        if ($email === null) {
            $email = text(
                label: 'Enter the new user email',
                required: true
            );
        }
        $password = password(
            label: 'Enter the new user password',
            required: true
        );
        $passwordConfirmation = password(
            label: 'Confirm the new user password',
            required: true
        );

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                $this->error($message);
            }
            return;
        }

        $validated = $validator->validated();
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $this->info('User account successfully created!');
    }
}
