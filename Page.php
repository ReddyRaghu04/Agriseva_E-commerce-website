<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriseva - Smart Agricultural Marketplace</title>
    <link rel="icon" href="Agriseva_icon.png" type="image/png">

    <!-- Google Fonts & Bootstrap 5 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Inline CSS for Premium Agro Experience -->
    <style>
        :root {
            --primary-green: #2e7d32;
            --primary-dark: #1b5e20;
            --accent-gold: #f57f17;
            --accent-orange: #e65100;
            --light-bg: #f4f7f4;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            --hover-shadow: 0 18px 40px rgba(46, 125, 50, 0.15);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--light-bg);
            color: #2c3e50;
            overflow-x: hidden;
        }

        /* Top Sticky Modern Navbar */
        .modern-navbar {
            background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 1040;
        }

        .brand-logo {
            font-size: 1.6rem;
            font-weight: 800;
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            letter-spacing: -0.5px;
        }

        .brand-logo:hover {
            color: #a5d6a7;
        }

        /* Live Search Bar */
        .search-container {
            position: relative;
            width: 100%;
            max-width: 480px;
        }

        .live-search-input {
            width: 100%;
            padding: 10px 20px 10px 45px;
            border-radius: 50px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            color: #ffffff;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .live-search-input::placeholder {
            color: rgba(255, 255, 255, 0.75);
        }

        .live-search-input:focus {
            outline: none;
            background: #ffffff;
            color: #1b5e20;
            border-color: #ffffff;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.4);
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.8);
            pointer-events: none;
        }

        .live-search-input:focus + .search-icon {
            color: #1b5e20;
        }

        /* Hero Banner */
        .agro-hero {
            background: linear-gradient(rgba(15, 42, 17, 0.75), rgba(15, 42, 17, 0.75)), url('Home_image.PNG') center/cover no-repeat;
            height: 280px;
            border-radius: 0 0 30px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            box-shadow: inset 0 -10px 30px rgba(0,0,0,0.3);
        }

        .hero-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Filter Controls Toolbar */
        .filter-toolbar {
            background: #ffffff;
            border-radius: 20px;
            padding: 16px 24px;
            margin-top: -35px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .category-pill {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .category-pill:hover, .category-pill.active {
            background: #2e7d32;
            color: #ffffff;
            border-color: #2e7d32;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.25);
        }

        .sort-select {
            border-radius: 50px;
            padding: 8px 20px;
            border: 1.5 solid #c8e6c9;
            font-size: 0.9rem;
            font-weight: 600;
            color: #2e7d32;
            background-color: #f1f8e9;
            cursor: pointer;
        }

        /* Product Cards */
        .product-card {
            background: #ffffff;
            border-radius: 20px;
            border: none;
            box-shadow: var(--card-shadow);
            transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--hover-shadow);
        }

        .card-img-wrapper {
            position: relative;
            height: 210px;
            overflow: hidden;
            background: #f8f9fa;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.08);
        }

        .discount-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: linear-gradient(135deg, #d32f2f, #b71c1c);
            color: #ffffff;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 50px;
            box-shadow: 0 4px 10px rgba(211, 47, 47, 0.3);
        }

        .category-tag {
            position: absolute;
            bottom: 12px;
            right: 12px;
            background: rgba(0, 0, 0, 0.65);
            backdrop-filter: blur(4px);
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 50px;
        }

        .product-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1b5e20;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .product-desc {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 16px;
            flex-grow: 1;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .price-section {
            display: flex;
            align-items: baseline;
            gap: 10px;
            margin-bottom: 16px;
        }

        .current-price {
            font-size: 1.35rem;
            font-weight: 800;
            color: #2e7d32;
        }

        .old-price {
            font-size: 0.95rem;
            color: #999;
            text-decoration: line-through;
        }

        .btn-buy {
            background: linear-gradient(135deg, #e65100 0%, #f57f17 100%);
            color: #ffffff;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            padding: 10px 16px;
            transition: all 0.3s ease;
        }

        .btn-buy:hover {
            box-shadow: 0 6px 15px rgba(230, 81, 0, 0.35);
            color: #ffffff;
            transform: translateY(-1px);
        }

        .btn-cart {
            background: #e8f5e9;
            color: #1b5e20;
            font-weight: 700;
            border: 1.5px solid #a5d6a7;
            border-radius: 12px;
            padding: 10px 16px;
            transition: all 0.3s ease;
        }

        .btn-cart:hover {
            background: #2e7d32;
            color: #ffffff;
            border-color: #2e7d32;
        }

        /* Floating AI Chat Assistant Drawer */
        .ai-chat-btn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
            color: #ffffff;
            border: none;
            border-radius: 50px;
            padding: 14px 24px;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 10px 25px rgba(27, 94, 32, 0.4);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 1050;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .ai-chat-btn:hover {
            transform: scale(1.05) translateY(-2px);
            box-shadow: 0 14px 30px rgba(27, 94, 32, 0.5);
        }

        .ai-drawer {
            position: fixed;
            bottom: 90px;
            right: 24px;
            width: 380px;
            max-width: calc(100vw - 32px);
            height: 520px;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.25);
            z-index: 1055;
            display: none;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid rgba(46, 125, 50, 0.15);
            animation: slideUp 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .ai-drawer-header {
            background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
            color: #ffffff;
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .ai-chat-body {
            flex-grow: 1;
            padding: 16px;
            overflow-y: auto;
            background: #f9fbf9;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .chat-bubble {
            max-width: 85%;
            padding: 12px 16px;
            border-radius: 18px;
            font-size: 0.88rem;
            line-height: 1.45;
        }

        .chat-bubble.user {
            background: #2e7d32;
            color: #ffffff;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
        }

        .chat-bubble.ai {
            background: #ffffff;
            color: #2c3e50;
            align-self: flex-start;
            border-bottom-left-radius: 4px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border: 1px solid #e8f5e9;
        }

        .chip-btn {
            background: #e8f5e9;
            color: #1b5e20;
            border: 1px solid #c8e6c9;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .chip-btn:hover {
            background: #2e7d32;
            color: #ffffff;
        }

        .ai-drawer-footer {
            padding: 12px 16px;
            background: #ffffff;
            border-top: 1px solid #eee;
            display: flex;
            gap: 8px;
        }

        .ai-input {
            border-radius: 50px;
            padding: 8px 16px;
            font-size: 0.9rem;
            border: 1.5px solid #c8e6c9;
        }

        .ai-input:focus {
            box-shadow: none;
            border-color: #2e7d32;
        }
    </style>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <!-- Sticky Modern Top Navigation Bar -->
    <nav class="modern-navbar">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                
                <!-- Brand Logo -->
                <a href="Page.php" class="brand-logo">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-flower1" viewBox="0 0 16 16">
                        <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                        <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                    </svg>
                    Agriseva
                </a>

                <!-- Real-Time Live Search Bar -->
                <div class="search-container flex-grow-1 mx-md-3 my-2 my-md-0">
                    <input type="text" id="liveSearchInput" class="live-search-input" placeholder="Search seeds, insecticides, fertilizers..." oninput="onLiveSearchInput()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-search search-icon" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                </div>

                <!-- Right Action Buttons -->
                <div class="d-flex align-items-center gap-2">
                    <?php if (isset($_SESSION['username'])): ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle rounded-pill fw-semibold px-3" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                👤 <?= isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'Account'; ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item py-2" href="My_profile.php">👤 My Profile</a></li>
                                <li><a class="dropdown-item py-2" href="fetch_cart.php">🛒 My Cart</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2 text-danger fw-semibold" href="User_logout.php">🚪 Logout</a></li>
                            </ul>
                        </div>
                        <?php if (isset($_SESSION['seller_id'])): ?>
                            <a href="sellers_dashboard.php" class="btn btn-warning rounded-pill fw-bold px-3">📊 Dashboard</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="User_Login.html" class="btn btn-light rounded-pill fw-bold text-success px-4">Login</a>
                        <a href="Login.php" class="btn btn-outline-light rounded-pill fw-semibold px-3">Become Seller</a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </nav>

    <!-- Hero Banner Section -->
    <div class="agro-hero">
        <span class="hero-badge">🌱 Smart Agricultural Marketplace</span>
        <h1 class="fw-extrabold display-5 mb-2">Quality Inputs for Higher Yields</h1>
        <p class="lead mb-0 text-light opacity-90">Certified Seeds • Effective Insecticides • AI Agronomist Support</p>
    </div>

    <!-- Filter & Toolbar Controls Container -->
    <div class="container mb-5">
        <div class="filter-toolbar">
            
            <!-- Category Filter Pills -->
            <div class="d-flex align-items-center flex-wrap gap-2">
                <button class="category-pill active" onclick="selectCategory('all', this)">All Products</button>
                <button class="category-pill" onclick="selectCategory('seeds', this)">🌾 Seeds</button>
                <button class="category-pill" onclick="selectCategory('paddy seeds', this)">🌾 Paddy Seeds</button>
                <button class="category-pill" onclick="selectCategory('cotton seeds', this)">🌱 Cotton Seeds</button>
                <button class="category-pill" onclick="selectCategory('insecticides', this)">🛡️ Insecticides</button>
            </div>

            <!-- Price Sort Control -->
            <div class="d-flex align-items-center gap-2">
                <span class="fw-semibold text-muted small">Sort By:</span>
                <select id="priceSortSelect" class="form-select sort-select" onchange="onSortChange()">
                    <option value="default">Featured</option>
                    <option value="low-high">Price: Low to High</option>
                    <option value="high-low">Price: High to Low</option>
                    <option value="discount">Highest Discount</option>
                </select>
            </div>

        </div>

        <!-- Section Title & Live Count -->
        <div class="d-flex justify-content-between align-items-center my-4">
            <h4 class="fw-bold mb-0 text-success">Available Products</h4>
            <span id="productCountBadge" class="badge bg-success rounded-pill px-3 py-2 fs-6">Loading...</span>
        </div>

        <!-- Products Grid Container -->
        <div class="row g-4" id="product-list">
            <!-- Dynamic Products Injected via Home_JS.js -->
        </div>
    </div>

    <!-- Floating AI Advisory Assistant Button -->
    <button class="ai-chat-btn" onclick="toggleAIDrawer()">
        🤖 AI Crop Advisor
    </button>

    <!-- AI Chat Drawer Panel -->
    <div class="ai-drawer" id="aiDrawer">
        <div class="ai-drawer-header">
            <div class="d-flex align-items-center gap-2">
                <span class="fs-5">🤖</span>
                <div>
                    <h6 class="fw-bold mb-0">Agriseva AI Advisor</h6>
                    <small style="font-size:0.75rem; opacity: 0.85;">Prompt Engineering Enabled</small>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white" onclick="toggleAIDrawer()"></button>
        </div>

        <div class="ai-chat-body" id="aiChatBody">
            <div class="chat-bubble ai">
                👋 <b>Hello Farmer!</b> How can I help you today?
                <br><br>You can ask me about crop diseases, pest controls, or recommended seed varieties.
            </div>

            <!-- Quick Suggestion Chips -->
            <div class="d-flex flex-wrap gap-1 mt-1">
                <button class="chip-btn" onclick="sendQuickPrompt('My cotton leaves are turning yellow, what insecticide to use?')">🟡 Cotton leaves yellowing?</button>
                <button class="chip-btn" onclick="sendQuickPrompt('Recommend high yield paddy seeds for this season.')">🌾 Best Paddy Seeds?</button>
                <button class="chip-btn" onclick="sendQuickPrompt('What is the best spray for crop pest attack?')">🐛 Pest Attack Spray?</button>
            </div>
        </div>

        <div class="ai-drawer-footer">
            <input type="text" id="aiQueryInput" class="form-control ai-input" placeholder="Type your crop question..." onkeypress="if(event.key==='Enter') sendAIQuery()">
            <button class="btn btn-success rounded-circle px-3" onclick="sendAIQuery()">➔</button>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="Home_JS.js"></script>
</body>
</html>