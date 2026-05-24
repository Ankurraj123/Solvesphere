<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// 1. Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/explore', [ProblemController::class, 'index'])->name('problems.index');
Route::get('/problems/{id}', [ProblemController::class, 'show'])->name('problems.show');
Route::get('/seed-database', function() {
    // 1. Ensure seed users exist (admin, user1, user2)
    $admin = \App\Models\User::firstOrCreate(
        ['email' => 'admin@solvesphere.com'],
        [
            'name' => 'Admin SolveSphere',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]
    );

    $user1 = \App\Models\User::firstOrCreate(
        ['email' => 'user1@solvesphere.com'],
        [
            'name' => 'Alex Developer',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'user',
        ]
    );

    $user2 = \App\Models\User::firstOrCreate(
        ['email' => 'user2@solvesphere.com'],
        [
            'name' => 'Sarah Coder',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'user',
        ]
    );

    // 2. Clear Categories, Problems, and Answers to clean up duplicates
    try {
        \App\Models\Category::query()->delete();
        \App\Models\Problem::query()->delete();
        \App\Models\Answer::query()->delete();
    } catch (\Exception $e) {
        foreach (\App\Models\Category::all() as $c) { $c->delete(); }
        foreach (\App\Models\Problem::all() as $p) { $p->delete(); }
        foreach (\App\Models\Answer::all() as $a) { $a->delete(); }
    }

    // 3. Create Categories cleanly
    $dsa = \App\Models\Category::create([
        'name' => 'DSA',
        'description' => 'Data Structures and Algorithms problems, including arrays, trees, graphs, and dynamic programming.',
    ]);

    $os = \App\Models\Category::create([
        'name' => 'Operating Systems',
        'description' => 'Threads, CPU scheduling, memory management, file systems, and system calls.',
    ]);

    $dbms = \App\Models\Category::create([
        'name' => 'DBMS',
        'description' => 'Database design, SQL queries, normalization, indexing, and transaction management.',
    ]);

    $webdev = \App\Models\Category::create([
        'name' => 'Web Development',
        'description' => 'Frontend styling, backend frameworks, REST APIs, state management, and cloud deployments.',
    ]);

    $networking = \App\Models\Category::create([
        'name' => 'Networking',
        'description' => 'OSI model layers, TCP/IP handshake, routing protocols, subnets, and network security.',
    ]);

    $laravel = \App\Models\Category::create([
        'name' => 'Laravel',
        'description' => 'Laravel MVC framework, Eloquent ORM, routing, middleware, and backend logic.',
    ]);

    $other = \App\Models\Category::create([
        'name' => 'Other',
        'description' => 'General computer science, programming questions, and off-topic technical discussions.',
    ]);

    // 4. Seed 3 Questions per Category

    // --- DSA ---
    $dsa1 = \App\Models\Problem::create([
        'user_id' => $user1->id,
        'category_id' => $dsa->id,
        'title' => 'How to optimize Longest Common Subsequence (LCS) to use O(min(m, n)) space?',
        'description' => "I am currently solving the classic Longest Common Subsequence problem using dynamic programming. My solution uses a 2D array of size O(m*n) space, where m and n are lengths of the strings.\n\nIs there an elegant way to reduce the space complexity to O(min(m, n)) since we only need the previous row's state to compute the current row's state? Any help or code snippet in Python or Java would be appreciated!",
        'image' => null,
        'status' => 'solved',
    ]);

    $dsa2 = \App\Models\Problem::create([
        'user_id' => $user2->id,
        'category_id' => $dsa->id,
        'title' => 'What is the difference between Merge Sort and Quick Sort in terms of stability and memory overhead?',
        'description' => "I am preparing for interviews and trying to understand the core differences between Merge Sort and Quick Sort. Specifically, why is Merge Sort stable while Quick Sort is not?\n\nAlso, why does Merge Sort require O(N) extra space while Quick Sort can be implemented in-place with O(log N) auxiliary space? Under what real-world scenarios should I prefer one over the other?",
        'image' => null,
        'status' => 'unsolved',
    ]);

    $dsa3 = \App\Models\Problem::create([
        'user_id' => $admin->id,
        'category_id' => $dsa->id,
        'title' => 'Optimal way to find the median of a running stream of integers?',
        'description' => "I am looking for an efficient way to find the median of a stream of integers. The integers are coming continuously, and at any point, I need to query the median of the numbers read so far.\n\nI heard this can be done using a dual-heap approach (Max-heap and Min-heap). Could someone provide the step-by-step logic and explain how the heaps are balanced?",
        'image' => null,
        'status' => 'unsolved',
    ]);

    // --- Operating Systems ---
    $os1 = \App\Models\Problem::create([
        'user_id' => $user2->id,
        'category_id' => $os->id,
        'title' => 'Why does thread switching have lower overhead than process switching?',
        'description' => "I am studying Operating Systems and I keep reading that context switching between threads is faster/cheaper than between processes. \n\nWhat are the low-level architectural reasons for this? Does it have to do with TLB flushing or address space isolation? Please explain in detail.",
        'image' => null,
        'status' => 'solved',
    ]);

    $os2 = \App\Models\Problem::create([
        'user_id' => $user1->id,
        'category_id' => $os->id,
        'title' => 'What is the difference between Hard Links and Symbolic (Soft) Links in Linux file systems?',
        'description' => "I'm trying to understand how links work at the inode level in Linux. What happens to the inode count when I create a hard link versus a soft link?\n\nAlso, what happens to the link if the original file is deleted or moved? Can we create a hard link to a directory or across different filesystems?",
        'image' => null,
        'status' => 'unsolved',
    ]);

    $os3 = \App\Models\Problem::create([
        'user_id' => $admin->id,
        'category_id' => $os->id,
        'title' => 'Why does Thrashing occur in Virtual Memory management and how can it be resolved?',
        'description' => "My server is experiencing extremely high page fault rates and the CPU utilization has dropped to near zero because it spends all its time swapping pages in and out of disk.\n\nWhy does this phenomenon (thrashing) happen? How does the Working Set Model or Page Fault Frequency (PFF) help prevent or mitigate thrashing?",
        'image' => null,
        'status' => 'unsolved',
    ]);

    // --- DBMS ---
    $dbms1 = \App\Models\Problem::create([
        'user_id' => $user1->id,
        'category_id' => $dbms->id,
        'title' => 'When should we normalize to Boyce-Codd Normal Form (BCNF) instead of 3NF?',
        'description' => "I'm designing a system for university course schedules. I've normalized my tables to 3NF, but I notice some transitive dependencies where non-prime attributes determine other attributes, and I am wondering if BCNF is necessary here. \n\nWhat are the trade-offs of going from 3NF to BCNF? Do we lose functional dependency preservation?",
        'image' => null,
        'status' => 'unsolved',
    ]);

    $dbms2 = \App\Models\Problem::create([
        'user_id' => $user2->id,
        'category_id' => $dbms->id,
        'title' => 'What is the difference between pessimistic locking and optimistic locking in database transactions?',
        'description' => "I am building a high-concurrency booking system and need to prevent double-booking. When should I use pessimistic locking (e.g., SELECT FOR UPDATE) vs optimistic locking (using a version field/timestamp)? What are the performance implications of each approach on database locks and connection pools?",
        'image' => null,
        'status' => 'solved',
    ]);

    $dbms3 = \App\Models\Problem::create([
        'user_id' => $admin->id,
        'category_id' => $dbms->id,
        'title' => 'How do B-Trees and B+ Trees differ, and why are B+ Trees preferred for database indexing?',
        'description' => "I understand that database indexes use B+ trees. How do B+ trees differ structurally from standard B-trees regarding keys and data storage in internal vs leaf nodes? Why does the linked list of leaf nodes in B+ trees make range queries and full scans so much faster?",
        'image' => null,
        'status' => 'unsolved',
    ]);

    // --- Web Development ---
    $web1 = \App\Models\Problem::create([
        'user_id' => $user2->id,
        'category_id' => $webdev->id,
        'title' => 'Best practices for securing cookie-based sessions in a decoupled Laravel backend & React frontend?',
        'description' => "We are building a SaaS product where the frontend is a SPA hosted on Vercel and the backend is a Laravel API hosted on AWS. We want to implement secure session cookies (Laravel Sanctum) instead of JWT.\n\nWhat are the config settings we need to change in config/cors.php and config/session.php to make sure it works across domains? Do we need to set SESSION_SECURE to true?",
        'image' => null,
        'status' => 'solved',
    ]);

    $web2 = \App\Models\Problem::create([
        'user_id' => $user1->id,
        'category_id' => $webdev->id,
        'title' => 'How to prevent CSRF attacks in a modern Single Page Application (React) communicating with a REST API?',
        'description' => "We are building a React frontend that communicates with a separate Express API. If we store our authentication JWT in local storage, we are vulnerable to XSS. If we store it in a secure HttpOnly cookie, we are vulnerable to CSRF.\n\nWhat is the standard way to protect against CSRF when using cookie-based authentication for APIs? Do we need to implement double-submit cookies or custom headers?",
        'image' => null,
        'status' => 'unsolved',
    ]);

    $web3 = \App\Models\Problem::create([
        'user_id' => $admin->id,
        'category_id' => $webdev->id,
        'title' => 'What is the difference between Server-Side Rendering (SSR) and Static Site Generation (SSG) in Next.js?',
        'description' => "I am starting a new blog and e-commerce project with Next.js and am confused about when to use SSR (getServerSideProps / dynamic rendering) versus SSG (getStaticProps / static exporting). Which one is better for SEO, and how does Incremental Static Regeneration (ISR) fit into this?",
        'image' => null,
        'status' => 'unsolved',
    ]);

    // --- Networking ---
    $net1 = \App\Models\Problem::create([
        'user_id' => $user1->id,
        'category_id' => $networking->id,
        'title' => 'How does the TCP 3-Way Handshake establish a connection and prevent half-open connections?',
        'description' => "Can someone break down the flags (SYN, SYN-ACK, ACK) and sequence numbers exchanged during a TCP 3-way handshake? What happens if the final ACK is lost? How does the timeout mechanism prevent server resources from being consumed by half-open connections?",
        'image' => null,
        'status' => 'solved',
    ]);

    $net2 = \App\Models\Problem::create([
        'user_id' => $user2->id,
        'category_id' => $networking->id,
        'title' => 'What is the difference between IPv4 subnetting and CIDR notation?',
        'description' => "I am learning networking and trying to understand classless inter-domain routing (CIDR). How did we move away from traditional Class A, B, and C networks?\n\nFor a subnet like 192.168.1.0/26, how do I calculate the total usable IP addresses, subnet mask, and broadcast address?",
        'image' => null,
        'status' => 'unsolved',
    ]);

    $net3 = \App\Models\Problem::create([
        'user_id' => $admin->id,
        'category_id' => $networking->id,
        'title' => 'How does DNS resolution work step-by-step from browser cache to root nameservers?',
        'description' => "When I type a URL like example.com in my browser, how is the IP address resolved? Please explain the roles of the browser cache, OS resolver, local ISP recursive resolver, Root nameservers, TLD nameservers, and Authoritative nameservers. What is the difference between recursive and iterative queries?",
        'image' => null,
        'status' => 'unsolved',
    ]);

    // --- Laravel ---
    $lar1 = \App\Models\Problem::create([
        'user_id' => $user1->id,
        'category_id' => $laravel->id,
        'title' => 'How to handle N+1 query problems in Laravel Eloquent relations?',
        'description' => "I have a Post model that has many Comments. When I display a list of posts and print the author of each comment using \$post->comments, Laravel runs a database query for every single post.\n\nHow can I use eager loading (with()) or lazy eager loading to solve this? Is there a way to enforce prevention of lazy loading in local development?",
        'image' => null,
        'status' => 'solved',
    ]);

    $lar2 = \App\Models\Problem::create([
        'user_id' => $user2->id,
        'category_id' => $laravel->id,
        'title' => 'What is the difference between Service Providers and Service Container in Laravel?',
        'description' => "I am trying to learn advanced Laravel concepts. What exactly is the Service Container, and how does it perform dependency injection?\n\nWhat are Service Providers, and how do they bind services or configurations during the application bootstrap phase?",
        'image' => null,
        'status' => 'unsolved',
    ]);

    $lar3 = \App\Models\Problem::create([
        'user_id' => $admin->id,
        'category_id' => $laravel->id,
        'title' => 'How to implement rate limiting for API routes using Laravel Sanctum?',
        'description' => "I want to protect my API endpoints from brute force and scraping. How do I configure custom rate limiters in RouteServiceProvider or bootstrap/app.php? Can I set different limits based on user tiers (e.g., guest vs premium authenticated users)?",
        'image' => null,
        'status' => 'unsolved',
    ]);

    // --- Other ---
    $oth1 = \App\Models\Problem::create([
        'user_id' => $user2->id,
        'category_id' => $other->id,
        'title' => 'What is the difference between git merge and git rebase, and when should I use which?',
        'description' => "I am collaborating on a team project. When integrating changes from a feature branch back to main, what are the architectural differences between merging (creating a merge commit) and rebasing (rewriting history)?\n\nWhat is the 'golden rule of rebasing' to avoid breaking other team members' history?",
        'image' => null,
        'status' => 'solved',
    ]);

    $oth2 = \App\Models\Problem::create([
        'user_id' => $user1->id,
        'category_id' => $other->id,
        'title' => 'How does public-key cryptography (RSA) work for secure data transmission?',
        'description' => "I understand that RSA uses a public key to encrypt and a private key to decrypt. What is the mathematical foundation behind this? How do prime numbers and modular exponentiation ensure that a message encrypted with the public key cannot be easily decrypted without the private key?",
        'image' => null,
        'status' => 'unsolved',
    ]);

    $oth3 = \App\Models\Problem::create([
        'user_id' => $admin->id,
        'category_id' => $other->id,
        'title' => 'What is Docker and how does containerization differ from traditional Virtual Machines?',
        'description' => "I want to containerize my Laravel app. How does Docker manage to run applications in isolation without the overhead of a full guest OS like VirtualBox or VMware? What are the roles of namespaces and cgroups in the Linux kernel for containerization?",
        'image' => null,
        'status' => 'unsolved',
    ]);

    // 5. Seed Answers for Solved Questions
    \App\Models\Answer::create([
        'problem_id' => $dsa1->id,
        'user_id' => $user2->id,
        'answer' => "Yes, you can absolutely optimize the space complexity! Since the recurrence relation is:\n`LCS[i][j] = LCS[i-1][j-1] + 1` if match, else `max(LCS[i-1][j], LCS[i][j-1])`,\nyou only ever need the current row and the previous row.\n\nHere is how you can implement it using a 1D array of size `min(m, n)`:\n\n```python\ndef lcs_space_optimized(s1, s2):\n    if len(s1) < len(s2):\n        s1, s2 = s2, s1\n    dp = [0] * (len(s2) + 1)\n    for char1 in s1:\n        prev = 0\n        for j in range(1, len(s2) + 1):\n            temp = dp[j]\n            if char1 == s2[j-1]:\n                dp[j] = prev + 1\n            else:\n                dp[j] = max(dp[j], dp[j-1])\n            prev = temp\n    return dp[-1]\n```\nThis drops your space complexity to O(min(m, n)) while maintaining O(m*n) time complexity.",
    ]);

    \App\Models\Answer::create([
        'problem_id' => $os1->id,
        'user_id' => $admin->id,
        'answer' => "The primary reason for the lower overhead of thread switching is that threads of the same process share the same virtual address space.\n\nWhen switching processes:\n1. The OS must switch page table base registers, flushing the Translation Lookaside Buffer (TLB).\n2. Cache lines become cold/invalid because different processes use different address space layouts.\n\nWhen switching threads within the same process:\n1. Address space is identical; no TLB flush occurs.\n2. Only CPU registers, Stack Pointer, and Program Counter need to be swapped, which is incredibly fast.",
    ]);

    \App\Models\Answer::create([
        'problem_id' => $dbms2->id,
        'user_id' => $user1->id,
        'answer' => "Pessimistic locking locks the rows immediately on selection (using `SELECT ... FOR UPDATE`), preventing other users from reading/writing until the transaction commits. Use this when collision rates are high.\n\nOptimistic locking does not lock rows at selection. Instead, it checks a `version` or `updated_at` column during the update statement (`UPDATE ... WHERE version = old_version`). If the version changed, it rolls back. Use this when concurrency conflicts are rare but need to be caught.",
    ]);

    \App\Models\Answer::create([
        'problem_id' => $web1->id,
        'user_id' => $user1->id,
        'answer' => "For Laravel Sanctum with cross-domain SPAs, here are the essential configurations:\n\n1. In your `.env` file, set:\n   `SESSION_DOMAIN=.yourdomain.com` (if on subdomains) or make sure `SANCTUM_STATEFUL_DOMAINS` is set.\n2. In `config/cors.php`, ensure `'supports_credentials' => true` is set so cookies are sent.\n3. Ensure your React Axios request has `withCredentials: true` globally enabled.\n4. For session security in production, set `SESSION_SECURE=true` and `SESSION_SAME_SITE=lax` or `none` (if domains are completely different, though `lax` is highly recommended for security).",
    ]);

    \App\Models\Answer::create([
        'problem_id' => $net1->id,
        'user_id' => $user2->id,
        'answer' => "The three steps are:\n1. **SYN**: Client sends a SYN packet with a random sequence number (e.g., X) to request a connection.\n2. **SYN-ACK**: Server replies with SYN-ACK packet, containing its own sequence number (Y) and acknowledges the client's packet by setting ACK = X + 1.\n3. **ACK**: Client sends an ACK packet with ACK = Y + 1 to confirm. The connection is now ESTABLISHED.\n\nIf the final ACK is lost, the server keeps re-sending SYN-ACK for a period before timing out and releasing the resources, preventing resource exhaustion.",
    ]);

    \App\Models\Answer::create([
        'problem_id' => $lar1->id,
        'user_id' => $admin->id,
        'answer' => "You can prevent the N+1 queries by using eager loading: \n`\$posts = Post::with('comments.user')->get();` \nThis runs only 2 database queries instead of N+1 queries.\n\nTo prevent lazy loading in development, you can add this to your `AppServiceProvider.php` `boot()` method:\n```php\nModel::preventLazyLoading(!app()->isProduction());\n```\nThis will throw an exception in local development whenever an N+1 query is triggered, making it easy to catch!",
    ]);

    \App\Models\Answer::create([
        'problem_id' => $oth1->id,
        'user_id' => $user1->id,
        'answer' => "Merging keeps the historical timeline of when commits were actually made, creating a distinct 'merge commit' to join the branches. This can look cluttered in busy repos.\n\nRebase takes your commits and reapplies them on top of the target branch, creating a completely linear history. \n\n**Golden Rule of Rebase:** Never rebase branches that are public or shared with others, as it rewrites history and breaks pull requests for anyone else working on that branch.",
    ]);

    return 'Database reset with 3 questions per category successfully!';
});

// 2. Guest-only Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// 3. Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Problems CRUD
    Route::get('/problems/create/new', [ProblemController::class, 'create'])->name('problems.create');
    Route::post('/problems', [ProblemController::class, 'store'])->name('problems.store');
    Route::get('/problems/{id}/edit', [ProblemController::class, 'edit'])->name('problems.edit');
    Route::put('/problems/{id}', [ProblemController::class, 'update'])->name('problems.update');
    Route::delete('/problems/{id}', [ProblemController::class, 'destroy'])->name('problems.destroy');
    Route::post('/problems/{id}/solved', [ProblemController::class, 'toggleSolved'])->name('problems.solved');

    // Answers CRUD
    Route::post('/problems/{problem_id}/answers', [AnswerController::class, 'store'])->name('answers.store');
    Route::put('/answers/{id}', [AnswerController::class, 'update'])->name('answers.update');
    Route::delete('/answers/{id}', [AnswerController::class, 'destroy'])->name('answers.destroy');
});

// 4. Admin-only Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Admin Category CRUD
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');

    // Admin User CRUD
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/{id}/role', [AdminController::class, 'toggleUserRole'])->name('admin.users.role');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // Content moderation
    Route::get('/content', [AdminController::class, 'content'])->name('admin.content');
});
