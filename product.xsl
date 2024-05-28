<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" doctype-public="-//W3C//DTD HTML 4.01 Transitional//EN"
    doctype-system="http://www.w3.org/TR/html4/loose.dtd" indent="yes" />
 
  <!-- JavaScript function to handle filtering and sorting -->
  <xsl:template name="javascript">
    <script type="text/javascript">
      <![CDATA[
      


      
      function filterAndSortProducts() {
        var teamCheckboxes = document.querySelectorAll('.filter-checkbox[name="team"]:checked');
        var jerseyCheckboxes = document.querySelectorAll('.filter-checkbox[name="jersey"]:checked');
        var yearCheckboxes = document.querySelectorAll('.filter-checkbox[name="year"]:checked');
        var sortSelect = document.getElementById('sort-select');
        var searchInput = document.getElementById('search-input').value.toLowerCase(); // Get the search input
        
        // Fetch all product elements
        var products = document.querySelectorAll('.product');
      
        // Iterate over each product to determine visibility
        products.forEach(function(product) {
          var showProduct = true;
      
          // Check if team checkbox is checked and filter products accordingly
          if (teamCheckboxes.length > 0) {
            var teamMatch = Array.from(teamCheckboxes).some(function(checkbox) {
              return product.dataset.team.includes(checkbox.value);
            });
            if (!teamMatch) {
              showProduct = false;
            }
          }
      
          // Check if jersey checkbox is checked and filter products accordingly
          if (jerseyCheckboxes.length > 0) {
            var jerseyMatch = Array.from(jerseyCheckboxes).some(function(checkbox) {
              return product.dataset.jersey.includes(checkbox.value);
            });
            if (!jerseyMatch) {
              showProduct = false;
            }
          }
      
          // Check if year checkbox is checked and filter products accordingly
          if (yearCheckboxes.length > 0) {
            var yearMatch = Array.from(yearCheckboxes).some(function(checkbox) {
              return product.dataset.year.includes(checkbox.value);
            });
            if (!yearMatch) {
              showProduct = false;
            }
          }
      
          // Check if search input matches the product name
          if (searchInput !== '') {
            var productName = product.querySelector('.product-name').textContent.toLowerCase();
            if (!productName.includes(searchInput)) {
              showProduct = false;
            }
          }
      
          // Show or hide the product based on filtering
          if (showProduct) {
            product.style.display = 'block';
          } else {
            product.style.display = 'none';
          }
        });
      
        // Sort the products based on the selected criteria
        var sortedProducts = Array.from(products);
      
        if (sortSelect.value === "A to Z") {
          sortedProducts.sort((a, b) => a.querySelector('.product-name').textContent.localeCompare(b.querySelector('.product-name').textContent));
        } else if (sortSelect.value === "Z to A") {
          sortedProducts.sort((a, b) => b.querySelector('.product-name').textContent.localeCompare(a.querySelector('.product-name').textContent));
        }
      
        // Clear the container
        var productContainer = document.getElementById('product-container');
        productContainer.innerHTML = '';
      
        // Append sorted products back to the container
        sortedProducts.forEach(function(product) {
          productContainer.appendChild(product);
        });
      }
      
      function sortProductsByPrice() {
        var productContainer = document.getElementById('product-container');
        var products = Array.from(productContainer.getElementsByClassName('product'));
        var sortOption = document.getElementById('sort-select-price').value;

        // Sort the products based on the selected criteria
        products.sort(function(a, b) {
          var priceAElement = a.querySelector('.product-price');
          var priceBElement = b.querySelector('.product-price');
        
          // Check if the elements exist before accessing their properties
          if (priceAElement && priceBElement) {
            var priceA = parseFloat(priceAElement.textContent.substring(1)); // Extract and parse price
            var priceB = parseFloat(priceBElement.textContent.substring(1)); // Extract and parse price
        
            // Sorting logic...
            console.log("click");
          }
        });

        // Clear the current product container
        productContainer.innerHTML = '';

        // Append sorted products back to the container
        products.forEach(function(product) {
          productContainer.appendChild(product);
        });

        // Trigger filtering after sorting
        filterAndSortProducts();
      }

  
      
    
      function sortProducts() {
        var productContainer = document.getElementById('product-container');
        var products = Array.from(productContainer.getElementsByClassName('product'));
        var sortOption = document.getElementById('sort-select').value;
      
        // Check if the selected option is "Sort Name"
        if (sortOption === "Sort Name") {
          // Reorder products to their original order
          var originalOrder = Array.from(products).sort((a, b) => a.dataset.index - b.dataset.index);
          originalOrder.forEach(function(product) {
            productContainer.appendChild(product);
          });
          // Trigger filtering after restoring original order
          filterAndSortProducts();
          return;
        }
      
        // Sort the products based on the selected criteria
        products.sort(function(a, b) {
          var nameA = a.getElementsByClassName('product-name')[0].innerText.toUpperCase();
          var nameB = b.getElementsByClassName('product-name')[0].innerText.toUpperCase();
          
          if (sortOption === 'A to Z') {
            return (nameA < nameB) ? -1 : (nameA > nameB) ? 1 : 0;
          } else {
            return (nameA > nameB) ? -1 : (nameA < nameB) ? 1 : 0;
          }
        });
      
        products.forEach(function(product) {
          productContainer.appendChild(product);
        });
      
        // Trigger filtering after sorting
        filterAndSortProducts();
      }
      
      window.onload = function() {
        var checkboxes = document.querySelectorAll('.filter-checkbox');
        checkboxes.forEach(function(checkbox) {
          checkbox.addEventListener('change', filterAndSortProducts);
        });
        
        var sortSelect = document.getElementById('sort-select');
        sortSelect.addEventListener('change', sortProducts);
        var sortSelectPrice = document.getElementById('sort-select-price');
        sortSelectPrice.addEventListener('change', sortProductsByPrice);
        // Fetch XML data and populate products
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            var xmlDoc = xhr.responseXML;
            var products = xmlDoc.getElementsByTagName('product');
            var productContainer = document.getElementById('product-container');
            for (var i = 0; i < products.length; i++) {
              var product = products[i];
              var ids = product.getElementsByTagName('prod_id')[0].childNodes[0].nodeValue;
              var idd = Number(ids) - 1;
              var name = product.getElementsByTagName('prod_name')[0].childNodes[0].nodeValue;
              var jersey = product.getElementsByTagName('prod_jersey')[0].childNodes[0].nodeValue;
              var price = product.getElementsByTagName('prod_price')[0].childNodes[0].nodeValue;
              var image = product.getElementsByTagName('prod_image')[0].childNodes[0].nodeValue;
              var team = product.getElementsByTagName('prod_team')[0].childNodes[0].nodeValue;
              var year = product.getElementsByTagName('prod_year')[0].childNodes[0].nodeValue;
      
              var productCard = `
                <div class="col-md-4 product" data-team="${team}" data-name="${name}" data-jersey="${jersey}" data-year="${year}" data-index="${idd}">
                  <div class="card mb-4 product-wap rounded-0">
                    <div class="card rounded-0">
                      <img class="card-img rounded-0" src="${image}" style="height: 280px;"/>
                    </div>
                    <div class="card-body text-start">
                      <a href="#" class="h3 text-decoration-none fs-5 product-name">${name}</a>
                      <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                        <li>
                          <span class="badge bg-primary">${jersey}</span>
                          <span class="badge bg-danger mx-1">${team}</span>
                          <span class="badge bg-success">${year}</span>
                        </li>
                        <li class="pt-2">
                          <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                          <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                          <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                          <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                          <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                        </li>
                      </ul>
                      
                      <p class="text-start mb-0 fs-4 fw-bold">$${price}</p>
                     
                      <a href="single_product_gw.html?id=${idd}name=${name}&team=${team}&${jersey}&year=${year}&price=${price}" class="btn btn-success my-2 fs-6" style="width: 100%;">Buy </a>
                      <a href="single_product.html" class="btn btn-warning  fs-6" style="width: 100%;">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                      </a>
                    </div>
                  </div>
                </div>
              `;
              productContainer.innerHTML += productCard;
            }
            // Call sorting by price after fetching products
            sortProductsByPrice();
          }
        };
        xhr.open('GET', 'product.xml', true);
        xhr.send();
      };
      ]]>
  
  </script>
  </xsl:template>


  <!-- Main template for generating the HTML -->
  <xsl:template match="/">
    <html lang="en">
      <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>King Brand</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/main.css" />
        <!-- Custom CSS -->
        <link rel="stylesheet" href="css/product-style.css" />
        <!-- Include Bootstrap JS and jQuery -->
        <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!-- Include JavaScript function -->
        <xsl:call-template name="javascript" />
      </head>
      <body>
        <!-- Navigation and other HTML elements -->
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
          <div class="container d-flex  ">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
              <img src="./images/mainlogo.png" alt="NBA Jersey Shop Logo" style="height: 60px;" /> <!--
              Adjust height as needed -->
              <span>King Brand</span>
            </a>

            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse"
              data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
              aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="index2.html" id="btn-home" >Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="product.xml">Shop</a>
                </li>
              </ul>
            </div>

            
          </div>
        </nav>

        <!-- Content -->
        <div class="container pt-3 pb-5">
          <div class="row">
            <div class="col-lg-3">
              <h1 class="h2 pb-1">Categories</h1>
              <ul class="list-unstyled templatemo-accordion overflow-y-scroll" style='height:70vh;'>
                <div class="form-check">
                  <li class="pb-3">
                    <a class="collapsed d-flex justify-content-evenly h5 text-decoration-none"
                      href="#" data-toggle="collapse" data-target="#team-checkboxes">
                      Team <i class="fas fa-chevron-down "></i> </a>
                    <ul id="team-checkboxes" class="collapse  list-unstyled pl-3">
                      <!-- Team checkboxes -->
                      <xsl:for-each select="products/product/prod_team[not(. = preceding::product/prod_team)]">
                        <xsl:sort select="." />
                        <xsl:variable name="team" select="." />
                        <li>
                          <input class="form-check-input filter-checkbox" type="checkbox"
                            name="team" value="{$team}" id="team-{$team}" />
                          <label class="form-check-label" for="team-{$team}"></label>
                          <a class="text-decoration-none check-box text-dark " href="#">
                            <xsl:value-of select="$team" />
                          </a>
                        </li>
                      </xsl:for-each>
                    </ul>
                  </li>
                </div>


                <div class="form-check">
                  <li class="pb-3">
                    <a class="collapsed d-flex justify-content-evenly h5 text-decoration-none"
                      href="#" data-toggle="collapse" data-target="#jersey-checkboxes" aria-expanded="false">
                      Jersey <i class="fas fa-chevron-down"></i>
                    </a>
                    <ul id="jersey-checkboxes" class="collapse list-unstyled pl-3"> <!-- Remove 'show' class -->
                      <xsl:for-each select="products/product/prod_jersey[not(. = preceding::product/prod_jersey)]">
                        <xsl:sort select="." />
                        <xsl:variable name="jersey" select="." type= "xs::string"/>
                        <li>
                          <input class="form-check-input filter-checkbox" type="checkbox"
                            name="jersey" value="{$jersey}" id="jersey-{$jersey}" />
                          <label class="form-check-label" for="jersey-{$jersey}"></label>
                          <a class="text-decoration-none check-box text-dark " href="#">
                            <xsl:value-of select="$jersey" />
                          </a>
                        </li>
                      </xsl:for-each>
                    </ul>
                  </li>
                </div>
                
                <div class="form-check">
                  <li class="pb-3">
                    <a class="collapsed d-flex justify-content-evenly h5 text-decoration-none"
                      href="#" data-toggle="collapse" data-target="#year-checkboxes">
                      Year <i class="fas fa-chevron-down "></i> </a>
                    <ul id="year-checkboxes" class="collapse  list-unstyled pl-3">
                      <xsl:for-each select="products/product/prod_year[not(. = preceding::product/prod_year)]">
                        <xsl:sort select="." order="descending" />
                        <xsl:variable name="year"
                          select="." />
                        <li>
                          <input class="form-check-input filter-checkbox" type="checkbox"
                            name="year" value="{$year}" id="year-{$year}" />
                          <label class="form-check-label" for="year-{$year}"></label>
                          <a class="text-decoration-none check-box text-dark " href="#">
                            <xsl:value-of select="$year" />
                          </a>
                        </li>
                      </xsl:for-each>
                    </ul>
                  </li>
                </div>
              </ul>
            </div>
            <div class="col-lg-9">

              <div class="row">
                <div class="col-md-6">
                  <form class="form-inline my-2 my-lg-0 d-flex">
                    <input id="search-input" class="form-control mr-sm-2 mx-2" type="search"
                      placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-success my-2 my-sm-0" type="button"
                      onclick="filterAndSortProducts()">Search</button>
                  </form>
                </div>

                <div class="col-md-6 pb-3">
                  <div class="d-flex">
                    <select id="sort-select" class="form-control">
                      <option>&#9660; Sort Name</option>

                      <option value="A to Z">A to Z</option>
                      <option value="Z to A">Z to A</option>
                    </select>
                    
                    <select id="sort-select-price" class="form-control" onchange="sortProductsByPrice()">
                      <option>&#9660; Sort Price</option>
                      <option>High to Low</option>
                      <option>Low to High</option>
                    </select>
                  </div>
                </div>
                
              </div>
              <div class="row overflow-y-scroll" style='height:80vh;' id='product-container'>
                <!-- Product listing will be inserted here dynamically -->
              </div>
            </div>
          </div>
        </div>
        <!-- End Content -->
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>
