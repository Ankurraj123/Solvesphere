<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Problem;
use App\Models\Answer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users
        $admin = User::create([
            'name' => 'Admin SolveSphere',
            'email' => 'admin@solvesphere.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $user1 = User::create([
            'name' => 'Alex Developer',
            'email' => 'user1@solvesphere.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $user2 = User::create([
            'name' => 'Sarah Coder',
            'email' => 'user2@solvesphere.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // 2. Seed Categories
        $dsa = Category::create([
            'name' => 'DSA',
            'description' => 'Data Structures and Algorithms problems, including arrays, trees, graphs, and dynamic programming.',
        ]);

        $os = Category::create([
            'name' => 'Operating Systems',
            'description' => 'Threads, CPU scheduling, memory management, file systems, and system calls.',
        ]);

        $dbms = Category::create([
            'name' => 'DBMS',
            'description' => 'Database design, SQL queries, normalization, indexing, and transaction management.',
        ]);

        $webdev = Category::create([
            'name' => 'Web Development',
            'description' => 'Frontend styling, backend frameworks, REST APIs, state management, and cloud deployments.',
        ]);

        $networking = Category::create([
            'name' => 'Networking',
            'description' => 'OSI model layers, TCP/IP handshake, routing protocols, subnets, and network security.',
        ]);

        // 3. Seed Problems
        $prob1 = Problem::create([
            'user_id' => $user1->id,
            'category_id' => $dsa->id,
            'title' => 'How to optimize Longest Common Subsequence (LCS) to use O(min(m, n)) space?',
            'description' => "I am currently solving the classic Longest Common Subsequence problem using dynamic programming. My solution uses a 2D array of size O(m*n) space, where m and n are lengths of the strings.\n\nIs there an elegant way to reduce the space complexity to O(min(m, n)) since we only need the previous row's state to compute the current row's state? Any help or code snippet in Python or Java would be appreciated!",
            'image' => null,
            'status' => 'solved',
        ]);

        $prob2 = Problem::create([
            'user_id' => $user2->id,
            'category_id' => $os->id,
            'title' => 'Why does thread switching have lower overhead than process switching?',
            'description' => "I am studying Operating Systems and I keep reading that context switching between threads is faster/cheaper than between processes. \n\nWhat are the low-level architectural reasons for this? Does it have to do with TLB flushing or address space isolation? Please explain in detail.",
            'image' => null,
            'status' => 'unsolved',
        ]);

        $prob3 = Problem::create([
            'user_id' => $user1->id,
            'category_id' => $dbms->id,
            'title' => 'When should we normalize to Boyce-Codd Normal Form (BCNF) instead of 3NF?',
            'description' => "I'm designing a system for university course schedules. I've normalized my tables to 3NF, but I notice some transitive dependencies where non-prime attributes determine other attributes, and I am wondering if BCNF is necessary here. \n\nWhat are the trade-offs of going from 3NF to BCNF? Do we lose functional dependency preservation?",
            'image' => null,
            'status' => 'unsolved',
        ]);

        $prob4 = Problem::create([
            'user_id' => $user2->id,
            'category_id' => $webdev->id,
            'title' => 'Best practices for securing cookie-based sessions in a decoupled Laravel backend & React frontend?',
            'description' => "We are building a SaaS product where the frontend is a SPA hosted on Vercel and the backend is a Laravel API hosted on AWS. We want to implement secure session cookies (Laravel Sanctum) instead of JWT.\n\nWhat are the config settings we need to change in config/cors.php and config/session.php to make sure it works across domains? Do we need to set SESSION_SECURE to true?",
            'image' => null,
            'status' => 'solved',
        ]);

        // 4. Seed Answers
        Answer::create([
            'problem_id' => $prob1->id,
            'user_id' => $user2->id,
            'answer' => "Yes, you can absolutely optimize the space complexity! Since the recurrence relation is:\n`LCS[i][j] = LCS[i-1][j-1] + 1` if match, else `max(LCS[i-1][j], LCS[i][j-1])`,\nyou only ever need the current row and the previous row.\n\nHere is how you can implement it using a 1D array of size `min(m, n)`:\n\n```python\ndef lcs_space_optimized(s1, s2):\n    if len(s1) < len(s2):\n        s1, s2 = s2, s1\n    dp = [0] * (len(s2) + 1)\n    for char1 in s1:\n        prev = 0\n        for j in range(1, len(s2) + 1):\n            temp = dp[j]\n            if char1 == s2[j-1]:\n                dp[j] = prev + 1\n            else:\n                dp[j] = max(dp[j], dp[j-1])\n            prev = temp\n    return dp[-1]\n```\nThis drops your space complexity to O(min(m, n)) while maintaining O(m*n) time complexity.",
        ]);

        Answer::create([
            'problem_id' => $prob2->id,
            'user_id' => $admin->id,
            'answer' => "The primary reason for the lower overhead of thread switching is that threads of the same process share the same virtual address space.\n\nWhen switching **processes**:\n1. The OS must switch the Page Table Base Register (e.g. CR3 in x86). This causes the Translation Lookaside Buffer (TLB) to be flushed (unless using ASID flags).\n2. A TLB flush means that subsequent memory accesses will result in slow page table page walks until the TLB is repopulated.\n3. Cache lines may become invalid/cold because the new process has a completely different memory footprint.\n\nWhen switching **threads** within the same process:\n1. The address space remains identical, so no page table register switch is needed, and the TLB contents remain valid.\n2. Only CPU registers, Stack Pointer, and Program Counter need to be swapped, which takes only a few instructions.\n3. The processor cache remains 'hot' since both threads share access to the same code, heap, and static data segments.",
        ]);

        Answer::create([
            'problem_id' => $prob4->id,
            'user_id' => $user1->id,
            'answer' => "For Laravel Sanctum with cross-domain SPAs, here are the essential configurations:\n\n1. In your `.env` file, set:\n   `SESSION_DOMAIN=.yourdomain.com` (if on subdomains) or make sure `SANCTUM_STATEFUL_DOMAINS` is set.\n2. In `config/cors.php`, ensure `'supports_credentials' => true` is set so cookies are sent.\n3. Ensure your React Axios request has `withCredentials: true` globally enabled.\n4. For session security in production, set `SESSION_SECURE=true` and `SESSION_SAME_SITE=lax` or `none` (if domains are completely different, though `lax` is highly recommended for security).",
        ]);
    }
}
