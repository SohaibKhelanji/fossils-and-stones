// Navbar
(() =>{
 
    const openNavMenu = document.querySelector(".open-nav-menu"),
    closeNavMenu = document.querySelector(".close-nav-menu"),
    navMenu = document.querySelector(".nav-menu"),
    menuOverlay = document.querySelector(".menu-overlay"),
    mediaSize = 991;
  
    openNavMenu.addEventListener("click", toggleNav);
    closeNavMenu.addEventListener("click", toggleNav);
    // close the navMenu by clicking outside
    menuOverlay.addEventListener("click", toggleNav);
  
    function toggleNav() {
        navMenu.classList.toggle("open");
        menuOverlay.classList.toggle("active");
        document.body.classList.toggle("hidden-scrolling");
    }
  
    navMenu.addEventListener("click", (event) =>{
        if(event.target.hasAttribute("data-toggle") && 
            window.innerWidth <= mediaSize){
            // prevent default anchor click behavior
            event.preventDefault();
            const menuItemHasChildren = event.target.parentElement;
          // if menuItemHasChildren is already expanded, collapse it
          if(menuItemHasChildren.classList.contains("active")){
              collapseSubMenu();
          }
          else{
            // collapse existing expanded menuItemHasChildren
            if(navMenu.querySelector(".menu-item-has-children.active")){
              collapseSubMenu();
            }
            // expand new menuItemHasChildren
            menuItemHasChildren.classList.add("active");
            const subMenu = menuItemHasChildren.querySelector(".sub-menu");
            subMenu.style.maxHeight = subMenu.scrollHeight + "px";
          }
        }
    });
    function collapseSubMenu(){
        navMenu.querySelector(".menu-item-has-children.active .sub-menu")
        .removeAttribute("style");
        navMenu.querySelector(".menu-item-has-children.active")
        .classList.remove("active");
    }
    function resizeFix(){
         // if navMenu is open ,close it
         if(navMenu.classList.contains("open")){
             toggleNav();
         }
         // if menuItemHasChildren is expanded , collapse it
         if(navMenu.querySelector(".menu-item-has-children.active")){
              collapseSubMenu();
       }
    }
  
    window.addEventListener("resize", function(){
       if(this.innerWidth > mediaSize){
           resizeFix();
       }
    });
  
  })();
  
 

  var search = document.getElementsByName("search")[0];
  var searchCategory = document.getElementsByName("searchCategory")[0];
  var searchUser = document.getElementsByName("searchUser")[0];
  var page = window.location.pathname;
  var page = page.split("/");
  var page = page[page.length - 1];




setInterval(function() {
if (page == "products.php") {


    if (search.value == "") {

      document.getElementById("all-products").style.display = "block";

    } else {

      document.getElementById("all-products").style.display = "none";

    }

}
if (page == "categories.php") {
    
    
    if (searchCategory.value == "") {

      document.getElementById("all-categories").style.display = "block";

    } else {

      document.getElementById("all-categories").style.display = "none";

    }

}
if (page == "usersAdmin.php") {
    
    
  if (searchUser.value == "") {

    document.getElementById("all-users").style.display = "block";

  } else {

    document.getElementById("all-users").style.display = "none";

  }

}
}, 100);





$(document).ready(function(){

    $("#search").keyup(function(){

        var search = $(this).val();
        
        if(search != ''){

            $.ajax({

                url:"ajax/search.php",
                method:"post",
                data:{search:search},
                success:function(response){
                    $("#search-results").html(response);
                }

            });

          }else{
              
              $("#search-results").html("");
  
          }

    });
  
  });


  $(document).ready(function(){

    $("#searchCategory").keyup(function(){

        var search = $(this).val();
        
        if(search != ''){

            $.ajax({

                url:"ajax/categorySearch.php",
                method:"post",
                data:{search:search},
                success:function(response){
                    $("#search-results-categories").html(response);
                }

            });

          }else{
              
              $("#search-results-categories").html("");
  
          }

    });
  
  });

  $(document).ready(function(){

    $("#searchUser").keyup(function(){

        var search = $(this).val();
        
        if(search != ''){

            $.ajax({

                url:"ajax/userSearch.php",
                method:"post",
                data:{search:search},
                success:function(response){
                    $("#search-results-users").html(response);
                }

            });

          }else{
              
              $("#search-results-users").html("");
  
          }

    });
  
  });

  function triggerClick() {
    document.querySelector('#productPictureUpload').click();
}

function displayImage(e) {
    if (e.files[0]){
         var reader = new FileReader();

        reader.onload = function(e) {
            document.querySelector('#productPictureDisplay').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}



// if #productAvailability is checked then value is true else false and if value is true then #productAvailability is checked
function checkAvailability() {
    if (document.getElementById('productAvailability').checked) {
        document.getElementById('productAvailability').value = "true";
    } else {
        document.getElementById('productAvailability').value = "false";
    }
}





