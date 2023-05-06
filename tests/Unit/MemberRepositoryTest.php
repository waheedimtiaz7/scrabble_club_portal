<?php

namespace Tests\Unit;

use App\Models\Member;
use Tests\TestCase;
use App\Repositories\MemberRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MemberRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected MemberRepository  $memberRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // Instantiate the MemberRepository
        $this->memberRepository = app(MemberRepository::class);
    }

    public function test_get_all_members()
    {
        // Seed the database with some dummy data
        //$this->seed();

        // Call the method being tested
        $members = $this->memberRepository->getAllMembers();

        // Assert that the method returns an array
        $this->assertIsObject($members);

        // Assert that the number of members returned is correct
        $this->assertCount(10, $members);

    }

    public function test_create_member()
    {
        // Define the member data to be created
        $data = [
            'name' => 'waheed2',
            'email' => 'waheed2@example.com',
            'phone' => '555-555-5555',
            'joining_date' => '1990-01-01'
        ];

        // Call the method being tested
        $member = $this->memberRepository->create($data);

        // Assert that the created member has the correct data
        $this->assertEquals('waheed2', $member->name);
        $this->assertEquals('waheed2@example.com', $member->email);
        $this->assertEquals('555-555-5555', $member->phone);
        $this->assertEquals('1990-01-01', $member->joining_date);
    }

    public function test_update_member()
    {
        // Seed the database with some dummy data
       // $this->seed();

        // Define the member data to be updated
        $data = [
            'name' => 'Waheed',
            'email' => 'waheed@mailinator.com',
            'phone' => '555-555-5555',
            'joining_date' => '1990-01-01'
        ];

        // Call the method being tested
        $member = $this->memberRepository->update(1, $data);

        // Assert that the updated member has the correct data
        $this->assertEquals('Waheed', $member->name);
        $this->assertEquals('waheed@mailinator.com', $member->email);
        $this->assertEquals('555-555-5555', $member->phone);
        $this->assertEquals('1990-01-01', $member->joining_date);
    }

    public function test_delete_member()
    {
        // Seed the database with some dummy data
        $data = [
            'name' => 'Waheed',
            'email' => 'waheed@mailinator.com',
            'phone' => '555-555-5555',
            'joining_date' => '1990-01-01'
        ];

        // Call the method being tested
        $member = $this->memberRepository->create($data);

        // Call the method being tested
        $result = $this->memberRepository->delete($member->id);

        // Assert that the method returns true
        $this->assertTrue($result);

        // Assert that the member has been deleted from the database
        $this->assertDatabaseMissing('members', ['email' => 'waheed@mailinator.com']);
    }
}
