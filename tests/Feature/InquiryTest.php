<?php

namespace Tests\Feature;

use App\Mail\InquiryMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;



class InquiryTest extends TestCase
{
    use RefreshDatabase;

    public function test_form_validation()
    {
        $response = $this->post('/contact', []);
        $response->assertSessionHasErrors(['name', 'email', 'phone', 'message']);
    }

    public function test_name_length_50_form_validation()
    {
        $longName = str_repeat('a', 51);
        $response = $this->post('/contact', [
            'name' => $longName
        ]);
        $response->assertSessionHasErrors(['name']);
        
    }

    public function test_email_length_50_form_validation()
    {
        $longEmail = str_repeat('a', 51) . '@example.com';
        $response = $this->post('/contact', [
            'email' => $longEmail
        ]);
        $response->assertSessionHasErrors(['email']);
    }

    public function test_is_email_valid_form_validation()
    {
        $response = $this->post('/contact', [
            'email' => "invalidemail"
        ]);
        $response->assertSessionHasErrors(['email']);
    }

    public function test_message_length_500_form_validation()
    {
        $someLongMessage = str_repeat('a', 501);
        $response = $this->post('/contact', [
            'message' => $someLongMessage
        ]);
        $response->assertSessionHasErrors(['message']);
    }

    public function test_form_saves_to_database()
    {
        $email = 'aleksander@abv.bg';
        $data = [
            'name' => 'Aleksander Aleksandrov',
            'email' => $email,
            'phone' => '1234567890',
            'message' => 'a4n8 inquiry!.',
        ];

        $this->post('/contact', $data);
        $this->assertDatabaseHas('inquiries', $data);
        
        $inquiry = Inquiry::where('email', $email)->first();
        $this->assertEquals($email, $inquiry->email);
    }
    public function test_inquiry_is_created_and_mail_is_sent()
    {
        Mail::fake();

        $data = [
            'name' => 'Aleksander Aleksandrov',
            'email' => 'aleksander@example.com',
            'phone' => '1234567890',
            'message' => 'Test!'
        ];

        $response = $this->post(route('contact.create'), $data);

        $this->assertDatabaseHas('inquiries', $data);
        
        Mail::assertSent(InquiryMail::class, function (InquiryMail $mail) use ($data) {
            $mailData = $mail->build();
            $this->assertTrue($mail->hasTo($data['email']));
            $this->assertEquals("Inquiry: #1 created!", $mail->subject);
            $this->assertEquals($mailData->viewData, $data);
            return true;
        });

        $response->assertRedirect(route('contact.index'))
                 ->assertSessionHas('success', 'Inquiry created!');
    }
}




