<!--
    - searchByProduct.php
    - for Sun Aviation, Inc.
    - created by Avery Wald on 6/5/18
    - Copyright (c) Sun Aviation, Incorporated
    - All rights reserved.
-->

<!doctype html>
<html>
    <meta charset="utf-8">
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-127575758-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-127575758-1');
        </script>

        <title>Search - Sun Aviation</title>
        <!-- favicon link-->
        <link rel="shortcut icon" type="img/png" href="../../pictures/favicon.png"  sizes="16x16">
        <!-- link to .css stylesheets -->
        <link rel="stylesheet" href="../cssFiles/headerFooterStyleSheet.css">
        <link rel="stylesheet" href="../cssFiles/searchPageStyleSheet.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
        integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt"
        crossorigin="anonymous">
        <!-- logo -->
        <div class="logo">
            <a href="../index.html">
                <img src="../pictures/sunAvLogo.png" alt="SunAV">
            </a>
        </div>
        <!-- top navbar-->
        <nav class="topNav">
            <!-- link buttons -->
            <div class="links">
                    <ul>
                        <li><a href="../htmlFiles/about.html">ABOUT</a></li>
                        <li><a href="../htmlFiles/contact.html">CONTACT</a></li>
                        <li><a href="../htmlFiles/products.html">PRODUCTS</a>
                            <ul>
                                <li><a href="../searchEngine/searchByProduct.php?search=1&submit=search">Altitude Encoders</a></li>
                                <li><a href="../searchEngine/searchByProduct.php?search=2&submit=search">Antennas</a></li>
                                <li><a href="../searchEngine/searchByProduct.php?search=3&submit=search">Avionics Supplies/Accessories</a></li>
                                <li><a href="../searchEngine/searchByProduct.php?search=4&submit=search">Emergency Locator Transmitters</a></li>
                                <li><a href="../searchEngine/searchByProduct.php?search=5&submit=search">Instruments</a></li>
                                <li><a href="../searchEngine/searchByProduct.php?search=6&submit=search">Lighting</a></li>
                                <li><a href="../searchEngine/searchByProduct.php?search=7&submit=search">Power Supplies & APU/GPUs</a></li>
                                <li><a href="../searchEngine/searchByProduct.php?search=8&submit=search">Test Equipment</a></li>
                            </ul>
                        </li>
                    </ul>
                    </div>
            <!-- search bar -->
            <div class="searchContainer">
                <!-- self - referencing search form -->
                <form class="example" action="search.php" method="GET">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                <input name="search" type="text" placeholder="search sunav.com...">
                <!-- search button -->
                <button name="submit" type="submit" value="search">
                    <i class="fa fa-search"></i>
                </button>
                </form>
            </div>
        </nav>  
        <!-- scroll button -->
        <div id="scrollContainer">
            <button id="scrollButton" onclick="topFunction()">&#11205</button>
        </div>
    </head>
<!-- ========================================================================== -->
    <body>
        <h1>Search</h1>
        <?php

        // grab sensitive credentials and data
        require 'searchConfig.php';

        // connect to database
        $pdo = new PDO($dsn, $user, $password);
        // set PDO default fetch to 'associative'
        // call db elements : '$elem['something']
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // database query value (product index code)
        $search = $_GET['search'];

        // store term in '$searchTerm'
        switch($search) {
            case 1:
                $searchTerm = 'Altitude Encoders';
                break;
            case 2:
                $searchTerm = 'Antennas';
                break;
            case 3:
                $searchTerm = 'Avionics Supplies & Accessories';
                break;
            case 4:
                $searchTerm = 'Emergency Locator Transmitters';
                break;
            case 5:
                $searchTerm = 'Instruments';
                break;
            case 6:
                $searchTerm = 'Lighting';
                break;
            case 7:
                $searchTerm = 'Power Supplies, APUs & GPUs';
                break;
            case 8:
                $searchTerm = 'Test Equipment';
                break;
        }

        // get search term indexed by code
        $sql = "SELECT Manufacturers.name, 
                    Products.partNumber,
                    Products.image,
                    Products.description
                FROM `Manufacturers`
                INNER JOIN `Products`
                ON Manufacturers.indexCode = Products.manufacturerCode
                WHERE Products.productType LIKE '{$search}'";

        // compile the search results
        $results = $pdo->query($sql);
        
        // count results and print #
        // no results
        if ($results->rowCount() == 0) {
            ?>
            <div class="resultsCount">
                <?php echo "0 results found for '<strong>$searchTerm</strong>'"; ?>
                <p>Consider navigating through the "Products" Tab</p>
            </div>
            <?php
        }
        // 1 result
        else if ($results->rowCount() == 1) {
            ?>
            <div class="resultsCount">
                <?php echo "1 result found for '<strong>$searchTerm</strong>'"; ?>
            </div>
            <?php
        }
        // multiple results
        else {
            ?>
            <div class="resultsCount">
                <?php echo $results->rowCount()." results found for '<strong>$searchTerm</strong>'"; ?>
            </div>
            <?php
        }
        // if no results, dont display info/order sheet link
        if ($results->rowCount() == 0) {
            ?>
            <style>
                #content {
                    display: none;
                }
            </style>
            <?php
        }

        ?>
        <div id="content">
            <div id="moreInfo">
                <h4>Click on images for more information</h4><br>
                <h4>For more product specs and pricing estimates, contact us<br>
                    or<br>
                    Fill out a 
                    <a href="../htmlFiles/contact.html#bodyText">
                        quote request form
                    </a>
                </h4>
            </div>
            <?php

            // print the results
            foreach ($results->fetchAll() as $result) {
                // get correct image path
                $imageFile = $result['image'];
                $imagePath = "../pictures/productImages/" . $imageFile;

                // end PHP and format results in HTML / CSS
                ?>
                
                <div class="resultBox">
                    <div class="imageContainer">
                        <?php echo "<img src='$imagePath' width='200px' height='200px'>" ?>
                        <div class="overlay" onclick="openModal()">
                            <?php echo "<h3>" . $result["name"] . "</h3>" ?>
                            <?php echo "<h3>" . $result["partNumber"] . "</h3>" ?>
                        </div>
                    </div>
                    <!-- modal box -->
                    <div class="modal">
                        <!-- x icon -->
                        <span class="closeIcon" onclick="closeModal()">
                            <i class="fas fa-times"></i>
                        </span>
                        <!-- next/prev buttons -->
                        <i id="prev" class="fas fa-chevron left" onclick='plusSlides(-1)'></i>
                        <i id="next" class="fas fa-chevron right" onclick='plusSlides(1)'></i>
                        <!-- product info -->
                        <div class="text">
                            <div class="title">
                                <?php echo "<h4>" . $result['name'] . "</h4>" ?>
                                <?php echo "<h3>" . $result['partNumber'] . "</h3>" ?>
                            </div>
                            <div class="details">
                                <?php echo "<p>" . $result['description'] . "</p>" ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                // resume PHP
            }

            ?>
        </div>
<!-- ========================================================================== -->
        <!-- footer -->
        <footer>
            <!-- footer navbar -->
            <nav class="botNav">
                <ul>
                    <li><a href="../index.html">HOME</a></li>
                    <li><a href="../htmlFiles/about.html">ABOUT</a></li>
                    <li><a href="../htmlFiles/contact.html#viewPortSpanner">ORDER</a></li>
                    <li><a href="../htmlFiles/products.html">PRODUCTS</a></li>
                </ul>
            </nav>
            <!-- footer info cell -->
            <div class="footerContent">
                <h3>Contact Us</h3>
                <div class="footerInfo">
                    <div class="address">
                        <p>Sun Aviation, Inc.</p>
                        <p>P.O. Box 11618</p>
                        <p>The Sun Aviation Building, 10010 E 87th Street</p>
                        <p>Kansas City, Missouri, USA 64138</p>
                    </div>
                    <div class="contactInfo">
                        <br>
                        <br>
                        <p>Phone: 816-358-4925</p>
                        <p>Email:
                            <a href="mailto:info@sunav.com">info@sunav.com</a>
                        </p>
                        <p>Fax: 816-737-0658</p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- backToTop javascript link -->
        <script src="../../javascriptFiles/backToTop.js"></script>
        <!-- modal.js link -->
        <script src="../../javascriptFils/modal.js"></script>
    </body>
</html>