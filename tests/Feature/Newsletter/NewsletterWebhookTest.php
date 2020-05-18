<?php

namespace Tests\Feature\Newsletter;

use App\Enums\MailChimpUnsubscribeWebhookAction;
use App\Enums\MailChimpWebhookType;
use App\Jobs\ProcessMailChimpWebhookJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Queue;
use Illuminate\Testing\TestResponse;
use Spatie\WebhookClient\WebhookConfig;
use Tests\TestCase;

class NewsletterWebhookTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected WebhookConfig $config;

    public function setUp(): void
    {
        parent::setUp();

        $mailChimpConfig = collect(Config::get('webhook-client.configs'))
            ->firstWhere('name', Config::get('webhook-client.names.newsletter'));

        $this->config = new WebhookConfig($mailChimpConfig);

        Queue::fake();
    }

    /** @test */
    public function it_returns_500_when_webhook_request_has_no_secret_passed(): void
    {
        $this->postWebHookRoute()->assertStatus(500);

        Queue::assertNothingPushed();
    }

    /** @test */
    public function it_returns_500_when_webhook_request_has_empty_secret(): void
    {
        $this->postWebHookRoute(['secret' => ''])->assertStatus(500);

        Queue::assertNothingPushed();
    }

    /** @test */
    public function it_returns_500_when_webhook_request_has_invalid_secret(): void
    {
        $this->postWebHookRoute(['secret' => 'invalid-secret'])->assertStatus(500);

        Queue::assertNothingPushed();
    }

    /** @test */
    public function it_returns_ok_when_webhook_request_is_unsupported_type(): void
    {
        $this->postWebHookRoute(
            ['secret' => $this->config->signingSecret],
            ['type' => 'unsupported-type']
        )->assertOk();

        Queue::assertNothingPushed();
    }

    /** @test */
    public function it_processes_job_when_webhook_request_is_supported_type(): void
    {
        Queue::assertNothingPushed();

        $this->postWebHookRoute(
            ['secret' => $this->config->signingSecret],
            ['type' => MailChimpWebhookType::UNSUBSCRIBE]
        )->assertOk();

        Queue::assertPushed(ProcessMailChimpWebhookJob::class);
    }

    protected function postWebHookRoute(array $parameters = [], array $data = []): TestResponse
    {
        return $this->post(route('webhook-client-mailchimp', $parameters), $data);
    }
}
