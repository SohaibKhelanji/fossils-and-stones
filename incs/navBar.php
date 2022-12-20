<header class="header">
     <div class="container">
        <div class="header-main">
           <div class="logo">
              <img src="imgs/logo.png" onclick="location.href='index.php';" style="cursor: pointer" alt="logo">
           </div>
           <div class="open-nav-menu">
              <span></span>
           </div>
           <div class="menu-overlay">
           </div>
           <nav class="nav-menu">
             <div class="close-nav-menu">
                <img src="imgs/close.svg" alt="close">
             </div>
             <?php if (!isset($_SESSION['userId'])) {
            echo "
            <ul class=\"menu\">
                <li class=\"menu-item\">
                   <a href=\"products.php\">Producten</a>
                </li>
                <li class=\"menu-item\">
                   <a href=\"#\">Contact</a>
                </li>
                <li class=\"menu-item menu-item-has-children\">
                   <a href=\"login.php\" data-toggle=\sub-menu\">Login<i class=\"plus\"></i></a>
                   <ul class=\"sub-menu\">
                       <li class=\"menu-item\"><a href=\"Login.php\">inloggen</a></li>
                       <li class=\"menu-item\"><a href=\"register.php\">Registreren</a></li>
                   </ul>
                </li>
                <li class=\"menu-item\">
                   <a href=\"shoppingCart.php\"><i class=\"fas fa-shopping-cart\"></i></a>
                </li>
             </ul>";
             } elseif (isset($_SESSION['userId']) && $_SESSION['userRole'] == "user") {
                echo" <ul class=\"menu\">
                <li class=\"menu-item\">
                   <a href=\"products.php\">Producten</a>
                </li>
                <li class=\"menu-item\">
                   <a href=\"#\">Contact</a>
                </li>
                <li class=\"menu-item menu-item-has-children\">
                   <a href=\"profile.php\" data-toggle=\sub-menu\">Account<i class=\"plus\"></i></a>
                   <ul class=\"sub-menu\">
                       <li class=\"menu-item\"><a href=\"profile.php\">Profiel</a></li>
                       <li class=\"menu-item\"><a href=\"orders.php\">Bestellingen</a></li>
                       <li class=\"menu-item\"><a href=\"logout.php\">Uitloggen</a></li>
                   </ul>
                </li>
                <li class=\"menu-item\">
                   <a href=\"shoppingCart.php\"><i class=\"fas fa-shopping-cart\"></i></a>
                </li>
             </ul>";
             } elseif (isset($_SESSION['userId']) && $_SESSION['userRole'] == "admin") {
               echo" <ul class=\"menu\">
               <li class=\"menu-item\">
                  <a href=\"products.php\">Producten</a>
               </li>
               <li class=\"menu-item\">
                  <a href=\"#\">Contact</a>
               </li>
               <li class=\"menu-item menu-item-has-children\">
                  <a href=\"#\" data-toggle=\sub-menu\">Admin<i class=\"plus\"></i></a>
                  <ul class=\"sub-menu\">
                      <li class=\"menu-item\"><a href=\"usersAdmin.php\">Gebruikers</a></li>
                      <li class=\"menu-item\"><a href=\"ordersAdmin.php\">Bestellingen</a></li>
                      <li class=\"menu-item\"><a href=\"logout.php\">Uitloggen</a></li>
                  </ul>
               </li>
            </ul>";
            }
             ?>
           </nav>
        </div>
     </div>
  </header>
      
    
