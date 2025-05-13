<?php
// Start session if it hasn't already been started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



// Pull in business logic layer and shared functions
require_once 'api/bll.phone.php'; 
require_once 'api/bll.phoneManager.php';
require_once 'functions.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    logoutUser();//logout function
}

// MasterPage class handles the full HTML structure
class MasterPage {
    private $title;
    private $mainContentTop = '';
    private $mainContentBottom = '';
    private $sidebarTop = '';
    private $sidebarBottom = '';
    private $phonesData = [];
    private $favouritePhone = '';

    public function __construct($title) {
        $this->title = $title;

        // Loading phones and favourite 
        $this->phonesData = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/Phone_CompareSite/data/phones.json'), true);

        if (isset($_SESSION['user'])) {
            $this->favouritePhone = $_SESSION['user']['favourite_phone'] ?? '';
        }
    }

    // Setters to fill different content 
    public function setMainContentTop($content) {
        $this->mainContentTop = $content;
    }

    public function setMainContentBottom($content) {
        $this->mainContentBottom = $content;
    }

    public function setSidebarTop($content) {
        $this->sidebarTop = $content;
    }

    public function setSidebarBottom($content) {
        $this->sidebarBottom = $content;
    }

    public function getPhonesData() {
        return $this->phonesData;
    }

    public function getFavouritePhone() {
        return $this->favouritePhone;
    }

    // Render the full HTML layout using above
    public function renderPage() {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo htmlspecialchars($this->title); ?></title>
            <!-- load downloaded bootstrap -->
            <link href="/Phone_CompareSite/page_assets/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
            <!-- load custom CSS -->
            <link href="/Phone_CompareSite/phone_comparison_site/styles.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        </head>
        <body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/Phone_CompareSite/page_assets/header.php'; ?>


            <div class="container-fluid">
                <div class="row">
                    <!-- Main content area -->
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-12 mb-3" style="min-height: 200px; border: 1px solid #ccc;">
                                <?php echo $this->mainContentTop; ?>
                            </div>
                            <div class="col-12" style="min-height: 200px; border: 1px solid #ccc;">
                                <?php echo $this->mainContentBottom; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar area -->
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-12 mb-3" style="min-height: 200px; border: 1px solid #ccc;">
                                <?php echo $this->sidebarTop; ?>
                            </div>
                            <div class="col-12" style="min-height: 200px; border: 1px solid #ccc;">
                                <?php echo $this->sidebarBottom; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php require_once __DIR__ . '/../page_assets/footer.php'; ?>

            <!-- JS assets at the bottom for performance -->
            <script src="/Phone_CompareSite/page_assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
            <script src="/Phone_CompareSite/js/search.js"></script>
            <script src="/Phone_CompareSite/js/compare.js?v=<?php echo time(); ?>"></script>
            <script src="/Phone_CompareSite/js/reviews.js"></script>
            <script src="/Phone_CompareSite/js/navbar.js"></script>
            <?php echo $compareInitScript ?? ''; ?>
        </body>
        </html>
        <?php
    }
}
?>
