<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\Channel;
use App\Models\Message;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        $admin = User::create([
            'name' => 'Jordan Blake',
            'email' => 'demo@comms.com',
            'password' => bcrypt('demo2026'),
            'role' => 'admin',
        ]);

        $sarah = User::create([
            'name' => 'Sarah Chen',
            'email' => 'sarah@comms.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $marcus = User::create([
            'name' => 'Marcus Williams',
            'email' => 'marcus@comms.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $priya = User::create([
            'name' => 'Priya Patel',
            'email' => 'priya@comms.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $alex = User::create([
            'name' => 'Alex Thompson',
            'email' => 'alex@comms.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Channels
        $general = Channel::create(['name' => 'General', 'type' => 'public', 'description' => 'Company-wide announcements and discussion']);
        $engineering = Channel::create(['name' => 'Engineering', 'type' => 'public', 'description' => 'Engineering team collaboration']);
        $sales = Channel::create(['name' => 'Sales', 'type' => 'private', 'description' => 'Sales team updates and pipeline']);
        $direct = Channel::create(['name' => 'Jordan & Sarah', 'type' => 'direct', 'description' => null]);

        // Assign users to channels
        $general->users()->attach([$admin->id, $sarah->id, $marcus->id, $priya->id, $alex->id]);
        $engineering->users()->attach([$admin->id, $marcus->id, $priya->id]);
        $sales->users()->attach([$admin->id, $sarah->id, $alex->id]);
        $direct->users()->attach([$admin->id, $sarah->id]);

        // Messages — General
        $this->seedMessages($general, [
            [$admin, 'Welcome to the new internal comms platform! Please take a moment to explore the channels and let me know if you have any questions.', '2026-03-10 09:00:00'],
            [$sarah, 'This looks great! Much better than the old email chains.', '2026-03-10 09:15:00'],
            [$marcus, 'Agreed. The channel organization is exactly what we needed.', '2026-03-10 09:22:00'],
            [$priya, 'Love the clean interface. Quick question — can we pin important messages?', '2026-03-10 09:30:00'],
            [$admin, 'Yes! Admins can pin messages to keep them visible at the top of the channel.', '2026-03-10 09:35:00'],
            [$alex, 'This will be perfect for coordinating with the sales team. No more digging through email threads.', '2026-03-10 10:00:00'],
            [$admin, 'Reminder: All-hands meeting tomorrow at 2pm. Agenda will be posted in this channel.', '2026-03-12 16:00:00', true],
            [$sarah, 'Will there be a recording for those who can\'t make it?', '2026-03-12 16:10:00'],
            [$admin, 'Yes, we\'ll share the recording and notes afterward.', '2026-03-12 16:15:00'],
            [$marcus, 'Thanks Jordan. Looking forward to the product roadmap update.', '2026-03-12 16:20:00'],
            [$priya, 'Just pushed the new authentication module to staging. Would love feedback from the team.', '2026-03-14 11:00:00'],
            [$alex, 'Q1 numbers are looking strong. Will share the full report in the sales channel.', '2026-03-14 14:30:00'],
            [$admin, 'Great work everyone this week. Enjoy the weekend!', '2026-03-14 17:00:00'],
            [$sarah, 'Happy Friday! Anyone up for virtual coffee Monday morning?', '2026-03-14 17:15:00'],
            [$marcus, 'Count me in!', '2026-03-14 17:20:00'],
        ]);

        // Messages — Engineering
        $this->seedMessages($engineering, [
            [$marcus, 'Sprint planning notes: we\'re focusing on the API refactor this sprint.', '2026-03-10 10:00:00'],
            [$priya, 'I\'ve drafted the new endpoint schema. PR is up for review: #247', '2026-03-10 14:00:00'],
            [$admin, 'Looks solid. A few comments on the error handling approach.', '2026-03-10 15:30:00'],
            [$marcus, 'CI pipeline is green. Deploying to staging now.', '2026-03-11 09:00:00'],
            [$priya, 'Found a race condition in the message queue handler. Investigating.', '2026-03-11 11:00:00'],
            [$marcus, 'Good catch. I saw some timeout errors in the logs too.', '2026-03-11 11:15:00'],
            [$priya, 'Fixed it. The mutex wasn\'t being released on timeout. PR #249 is up.', '2026-03-11 14:00:00'],
            [$admin, 'Merged. Nice work Priya. Let\'s add a regression test for this.', '2026-03-11 14:30:00'],
            [$marcus, 'Database migration for the new audit system is ready. Need someone to review the schema.', '2026-03-13 09:00:00'],
            [$priya, 'I\'ll review it this afternoon.', '2026-03-13 09:15:00'],
        ]);

        // Messages — Sales
        $this->seedMessages($sales, [
            [$sarah, 'Pipeline update: 3 new enterprise leads this week.', '2026-03-10 11:00:00'],
            [$alex, 'Acme Corp demo went well. They\'re requesting a custom integration.', '2026-03-10 14:00:00'],
            [$admin, 'What\'s the timeline on the Acme deal?', '2026-03-10 14:30:00'],
            [$alex, 'They want to close by end of Q1. Working on the proposal now.', '2026-03-10 14:45:00'],
            [$sarah, 'I can help with the proposal. I worked with their industry before.', '2026-03-10 15:00:00'],
            [$alex, 'That would be great! Let\'s sync tomorrow.', '2026-03-10 15:10:00'],
            [$sarah, 'Monthly revenue report: we\'re 12% ahead of target.', '2026-03-13 10:00:00', true],
            [$admin, 'Excellent numbers. Let\'s keep the momentum going.', '2026-03-13 10:30:00'],
        ]);

        // Messages — Direct
        $this->seedMessages($direct, [
            [$admin, 'Hey Sarah, wanted to check in about the client presentation. How are you feeling about it?', '2026-03-11 09:00:00'],
            [$sarah, 'Pretty good! I\'ve got the slides ready. Just need to finalize the demo walkthrough.', '2026-03-11 09:10:00'],
            [$admin, 'Great. Let me know if you need any help with the technical sections.', '2026-03-11 09:15:00'],
            [$sarah, 'Actually, could you review the security compliance section? Want to make sure we\'re accurate.', '2026-03-11 09:20:00'],
            [$admin, 'Of course. Send it over and I\'ll take a look this afternoon.', '2026-03-11 09:25:00'],
            [$sarah, 'Thanks Jordan! You\'re the best.', '2026-03-11 09:30:00'],
        ]);

        // Tickets
        $t1 = Ticket::create([
            'reference' => 'TICKET-000001',
            'user_id' => $sarah->id,
            'assigned_to' => $admin->id,
            'subject' => 'Cannot access Engineering channel',
            'description' => 'I\'m trying to view the Engineering channel but getting a permission denied error. I was added to the team last week and should have access.',
            'priority' => 'high',
            'category' => 'access',
            'status' => 'resolved',
        ]);

        $t2 = Ticket::create([
            'reference' => 'TICKET-000002',
            'user_id' => $marcus->id,
            'assigned_to' => $admin->id,
            'subject' => 'Message search not returning recent results',
            'description' => 'When I search for messages from today, the search results only show messages from last week. The index might need to be rebuilt.',
            'priority' => 'medium',
            'category' => 'technical',
            'status' => 'in_progress',
        ]);

        $t3 = Ticket::create([
            'reference' => 'TICKET-000003',
            'user_id' => $priya->id,
            'assigned_to' => null,
            'subject' => 'Request for dark mode support',
            'description' => 'Would love to have a dark mode option for the platform. Working late hours with a bright interface is straining on the eyes.',
            'priority' => 'low',
            'category' => 'general',
            'status' => 'open',
        ]);

        $t4 = Ticket::create([
            'reference' => 'TICKET-000004',
            'user_id' => $alex->id,
            'assigned_to' => $admin->id,
            'subject' => 'Billing discrepancy on enterprise plan',
            'description' => 'Our last invoice shows charges for 50 seats but we only have 35 active users. Please review and adjust.',
            'priority' => 'urgent',
            'category' => 'billing',
            'status' => 'waiting',
        ]);

        $t5 = Ticket::create([
            'reference' => 'TICKET-000005',
            'user_id' => $sarah->id,
            'assigned_to' => $marcus->id,
            'subject' => 'File upload failing for large attachments',
            'description' => 'Trying to upload a 25MB PDF and the upload fails at 80%. Smaller files work fine. Is there a size limit we need to increase?',
            'priority' => 'high',
            'category' => 'technical',
            'status' => 'in_progress',
        ]);

        $t6 = Ticket::create([
            'reference' => 'TICKET-000006',
            'user_id' => $marcus->id,
            'assigned_to' => $admin->id,
            'subject' => 'Need API documentation for integrations',
            'description' => 'Our team is building an integration with the project management tool. Where can we find the API documentation?',
            'priority' => 'medium',
            'category' => 'general',
            'status' => 'closed',
        ]);

        // Ticket Replies
        TicketReply::create(['ticket_id' => $t1->id, 'user_id' => $admin->id, 'body' => 'I\'ve checked the permissions and it looks like your account wasn\'t added to the Engineering group properly. Fixing now.', 'created_at' => '2026-03-11 10:00:00', 'updated_at' => '2026-03-11 10:00:00']);
        TicketReply::create(['ticket_id' => $t1->id, 'user_id' => $admin->id, 'body' => 'Done! You should now have access to the Engineering channel. Please try again and let me know.', 'created_at' => '2026-03-11 10:15:00', 'updated_at' => '2026-03-11 10:15:00']);
        TicketReply::create(['ticket_id' => $t1->id, 'user_id' => $sarah->id, 'body' => 'It works now! Thank you for the quick fix.', 'created_at' => '2026-03-11 10:30:00', 'updated_at' => '2026-03-11 10:30:00']);

        TicketReply::create(['ticket_id' => $t2->id, 'user_id' => $admin->id, 'body' => 'Thanks for reporting this. I\'m looking into the search indexer — it may need to be resynced.', 'created_at' => '2026-03-12 09:00:00', 'updated_at' => '2026-03-12 09:00:00']);
        TicketReply::create(['ticket_id' => $t2->id, 'user_id' => $marcus->id, 'body' => 'Any update on this? Still seeing stale results.', 'created_at' => '2026-03-13 14:00:00', 'updated_at' => '2026-03-13 14:00:00']);

        TicketReply::create(['ticket_id' => $t4->id, 'user_id' => $admin->id, 'body' => 'I\'ve escalated this to the billing team. They\'ll review and issue a credit if there was an overcharge.', 'created_at' => '2026-03-12 11:00:00', 'updated_at' => '2026-03-12 11:00:00']);
        TicketReply::create(['ticket_id' => $t4->id, 'user_id' => $alex->id, 'body' => 'Thanks Jordan. Can you keep me posted on the timeline?', 'created_at' => '2026-03-12 11:30:00', 'updated_at' => '2026-03-12 11:30:00']);

        TicketReply::create(['ticket_id' => $t5->id, 'user_id' => $marcus->id, 'body' => 'I can look into this. The default upload limit is 10MB. I\'ll check the server config.', 'created_at' => '2026-03-13 10:00:00', 'updated_at' => '2026-03-13 10:00:00']);

        TicketReply::create(['ticket_id' => $t6->id, 'user_id' => $admin->id, 'body' => 'The API docs are available at /api/docs. I\'ll also share the Postman collection with your team.', 'created_at' => '2026-03-10 16:00:00', 'updated_at' => '2026-03-10 16:00:00']);
        TicketReply::create(['ticket_id' => $t6->id, 'user_id' => $marcus->id, 'body' => 'Perfect, that\'s exactly what we needed. Closing this out.', 'created_at' => '2026-03-10 16:30:00', 'updated_at' => '2026-03-10 16:30:00']);

        // Audit Logs
        AuditLog::create([
            'admin_id' => $admin->id,
            'auditable_type' => 'message',
            'auditable_id' => 7,
            'original_timestamp' => '2026-03-12 16:00:00',
            'modified_timestamp' => '2026-03-12 15:45:00',
            'reason' => 'Corrected meeting reminder timestamp to reflect actual send time before system delay',
        ]);

        AuditLog::create([
            'admin_id' => $admin->id,
            'auditable_type' => 'ticket_reply',
            'auditable_id' => 1,
            'original_timestamp' => '2026-03-11 10:00:00',
            'modified_timestamp' => '2026-03-11 09:55:00',
            'reason' => 'Adjusted reply timestamp — admin responded before ticket was officially logged due to direct conversation',
        ]);

        AuditLog::create([
            'admin_id' => $admin->id,
            'auditable_type' => 'message',
            'auditable_id' => 11,
            'original_timestamp' => '2026-03-14 11:00:00',
            'modified_timestamp' => '2026-03-14 10:45:00',
            'reason' => 'Employee requested timestamp correction — message was composed earlier but sent late due to connectivity issue',
        ]);
    }

    private function seedMessages(Channel $channel, array $messages): void
    {
        foreach ($messages as $msg) {
            Message::create([
                'channel_id' => $channel->id,
                'user_id' => $msg[0]->id,
                'body' => $msg[1],
                'is_pinned' => $msg[3] ?? false,
                'created_at' => $msg[2],
                'updated_at' => $msg[2],
            ]);
        }
    }
}
