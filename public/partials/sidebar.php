<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav class="bg-dark text-white flex-shrink-0" style="width: 15rem; min-height: 100vh;">
    <ul class="nav flex-column mt-3">
        <!-- Dashboard -->
        <li class="nav-item <?php echo ($currentPage == 'dashboard.php') ? 'badge text-bg-light text-light text-wrap ms-4 rounded-0 rounded-start-pill mt-3' : ''; ?>">
            <div class="d-flex align-items-center w-100 <?php echo ($currentPage == 'dashboard.php') ? 'py-1 ps-3' : 'ms-5 py-2'; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="<?php echo ($currentPage == 'dashboard.php') ? '#000' : '#fff'; ?>" d="M13 3v6h8V3m-8 18h8V11h-8M3 21h8v-6H3m0-2h8V3H3z" />
                </svg>
                <a href="dashboard.php" class="nav-link <?php echo ($currentPage == 'dashboard.php') ? 'text-dark' : 'text-light'; ?>">Dashboard</a>
            </div>
        </li>

        <!-- List News -->
        <li class="nav-item <?php echo ($currentPage == 'list-news.php') ? 'badge text-bg-light text-light text-wrap ms-4 rounded-0 rounded-start-pill' : ''; ?>">
            <div class="d-flex align-items-center w-100 <?php echo ($currentPage == 'list-news.php') ? 'py-1 ps-3' : 'ms-5 py-2'; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 16 16">
                    <path fill="<?php echo ($currentPage == 'list-news.php') ? '#000' : '#fff'; ?>" d="M3.5 5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5zM4 9V8h1v1zm3.5-2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM1 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2a2 2 0 0 1 2 2v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 10.5zm11.5 6.5a.5.5 0 0 1-.5-.5V4a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v6.5A1.5 1.5 0 0 0 3.5 12h9a1.5 1.5 0 0 0 1.5-1.5V6a1 1 0 0 0-1-1v5a.5.5 0 0 1-.5.5" />
                </svg>
                <a href="list-news.php" class="nav-link <?php echo ($currentPage == 'list-news.php') ? 'text-dark' : 'text-light'; ?>">List News</a>
            </div>
        </li>
    </ul>
</nav>