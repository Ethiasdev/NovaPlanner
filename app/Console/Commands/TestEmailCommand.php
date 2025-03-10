<?php

namespace App\Console\Commands;

use App\Mail\AppointmentConfirmation;
use App\Models\Appointment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email=test@example.com}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test appointment confirmation email via Mailtrap';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info("Sending test email to: {$email}");
        
        // Create a dummy appointment for testing
        $appointment = new Appointment([
            'name' => 'Test Gebruiker',
            'email' => $email,
            'phone' => '06-12345678',
            'date' => now()->addDays(2),
            'time' => '14:00',
            'notes' => 'Dit is een test afspraak om de e-mail configuratie te testen.',
            'status' => 'nieuw',
        ]);
        
        try {
            // Send test email
            Mail::to($email)->send(new AppointmentConfirmation($appointment));
            
            $this->info("✅ Test email successfully sent to {$email}!");
            $this->info("📧 Check your Mailtrap inbox to see the email.");
            $this->line("Email details:");
            $this->line("- To: {$email}");
            $this->line("- Subject: Bevestiging van uw afspraak bij NovaPlanner");
            $this->line("- Content: Appointment confirmation with test data");
            
        } catch (\Exception $e) {
            $this->error("❌ Failed to send test email: " . $e->getMessage());
            $this->line("Please check your .env file mail configuration:");
            $this->line("MAIL_MAILER=" . config('mail.default'));
            $this->line("MAIL_HOST=" . config('mail.mailers.smtp.host'));
            $this->line("MAIL_PORT=" . config('mail.mailers.smtp.port'));
            $this->line("MAIL_USERNAME=" . config('mail.mailers.smtp.username'));
            
            return 1;
        }
        
        return 0;
    }
}
