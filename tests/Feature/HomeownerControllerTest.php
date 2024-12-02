<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class HomeownerControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_parses_single_name()
    {
        $file = UploadedFile::fake()->createWithContent('homeowners.csv', "Mr John Doe\n");

        $response = $this->post(route('upload'), [
            'csv_file' => $file,
        ]);

        $response->assertStatus(200);
        $response->assertViewHas('people', [
            ['title' => 'Mr', 'first_name' => 'John', 'initial' => null, 'last_name' => 'Doe']
        ]);
    }

    /** @test */
    public function it_parses_two_full_names()
    {
        $file = UploadedFile::fake()->createWithContent('homeowners.csv', "Mr John Doe, Mrs Jane Smith\n");

        $response = $this->post(route('upload'), [
            'csv_file' => $file,
        ]);

        $response->assertStatus(200);
        $response->assertViewHas('people', [
            ['title' => 'Mr', 'first_name' => 'John', 'initial' => null, 'last_name' => 'Doe'],
            ['title' => 'Mrs', 'first_name' => 'Jane', 'initial' => null, 'last_name' => 'Smith']
        ]);
    }

    /** @test */
    public function it_parses_four_full_names()
    {
        $file = UploadedFile::fake()->createWithContent('homeowners.csv', "Mr John Doe, Mrs Jane Smith, Prof Bob Reed, Miss A Hablach\n");

        $response = $this->post(route('upload'), [
            'csv_file' => $file,
        ]);

        $response->assertStatus(200);
        $response->assertViewHas('people', [
            ['title' => 'Mr', 'first_name' => 'John', 'initial' => null, 'last_name' => 'Doe'],
            ['title' => 'Mrs', 'first_name' => 'Jane', 'initial' => null, 'last_name' => 'Smith'],
            ['title' => 'Prof', 'first_name' => 'Bob', 'initial' => null, 'last_name' => 'Reed'],
            ['title' => 'Miss', 'first_name' => null, 'initial' => 'A', 'last_name' => 'Hablach']

        ]);
    }

    /** @test */
    public function it_parses_two_names_with_initial()
    {
        $file = UploadedFile::fake()->createWithContent('homeowners.csv', "Mr J Doe, Mrs J. Smith\n");

        $response = $this->post(route('upload'), [
            'csv_file' => $file,
        ]);

        $response->assertStatus(200);
        $response->assertViewHas('people', [
            ['title' => 'Mr', 'first_name' => null, 'initial' => 'J', 'last_name' => 'Doe'],
            ['title' => 'Mrs', 'first_name' => null, 'initial' => 'J', 'last_name' => 'Smith']
        ]);
    }

    /** @test */
    public function it_parses_two_names_with_initial_and_first_name()
    {
        $file = UploadedFile::fake()->createWithContent('homeowners.csv', "Mr Joe Doe, Mrs J. Smith\n");

        $response = $this->post(route('upload'), [
            'csv_file' => $file,
        ]);

        $response->assertStatus(200);
        $response->assertViewHas('people', [
            ['title' => 'Mr', 'first_name' => 'Joe', 'initial' => null, 'last_name' => 'Doe'],
            ['title' => 'Mrs', 'first_name' => null, 'initial' => 'J', 'last_name' => 'Smith']
        ]);
    }

    /** @test */
    public function it_parses_titles_with_shared_last_name()
    {
        $file = UploadedFile::fake()->createWithContent('homeowners.csv', "Mr and Mrs Doe\n");

        $response = $this->post(route('upload'), [
            'csv_file' => $file,
        ]);

        $response->assertStatus(200);
        $response->assertViewHas('people', [
            ['title' => 'Mr', 'first_name' => null, 'initial' => null, 'last_name' => 'Doe'],
            ['title' => 'Mrs', 'first_name' => null, 'initial' => null, 'last_name' => 'Doe']
        ]);
    }

    /** @test */
    public function it_parses_double_barrelled_last_name()
    {
        $file = UploadedFile::fake()->createWithContent('homeowners.csv', "Mr John Smith-Jones, Mrs Jane Smith-Jones\n");

        $response = $this->post(route('upload'), [
            'csv_file' => $file,
        ]);

        $response->assertStatus(200);
        $response->assertViewHas('people', [
            ['title' => 'Mr', 'first_name' => 'John', 'initial' => null, 'last_name' => 'Smith-Jones'],
            ['title' => 'Mrs', 'first_name' => 'Jane', 'initial' => null, 'last_name' => 'Smith-Jones']
        ]);
    }

    /** @test */
    public function it_parses_titles_first_and_last_name()
    {
        $file = UploadedFile::fake()->createWithContent('homeowners.csv', "Mr and Mrs John Doe\n");

        $response = $this->post(route('upload'), [
            'csv_file' => $file,
        ]);

        $response->assertStatus(200);
        $response->assertViewHas('people', [
            ['title' => 'Mr', 'first_name' => 'John', 'initial' => null, 'last_name' => 'Doe'],
            ['title' => 'Mrs', 'first_name' => null, 'initial' => null, 'last_name' => 'Doe']
        ]);
    }
}
