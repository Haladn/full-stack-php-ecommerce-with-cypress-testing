describe('test navbar, navigation links and search engin in cart', () => {
  // before each test visit the following
  beforeEach(()=>{
    cy.visit('http://localhost/php_ecommerce/user/cart.php')
  })
  it('check url', () => {
    
    // check url that contain cart.php
    cy.url().should('eq','http://localhost/php_ecommerce/user/cart.php')
    .and('contain','cart.php')

  })

  it('get navbar element a check individual element on it',()=>{
    // get root navbar containar
    cy.get("[data-cy='navbar']").should('exist')
    .and('have.class','navbar')
    .and('have.class','navbar-expand-lg')
    .and('have.class','navbar-dark')
    .and('have.class','bg-dark')
    
    // check children element of the root container
    cy.get("[data-cy='navbar']").as('navbar')
    cy.get('@navbar').find('div.container-fluid').should('exist')
    
    // get children of div with class container-fluid
    cy.get('div.container-fluid').children('a.navbar-brand')
    .should('have.text','MKTIME')

    // get toggler button
    cy.get('button.navbar-toggler').should('exist')
    .and('have.attr','data-bs-toggle','collapse')
    .and('have.attr','aria-expanded','false')
    .and('have.attr','data-bs-target','#navigators')

    //check span element inside toggler button
    cy.get('button.navbar-toggler').children('span')
    .should('exist')
    .and('have.class','navbar-toggler-icon')

    // check toggle visibility in large screen
    cy.get('button.navbar-toggler').should('not.be.visible')

    // check if target div has collapse class
    cy.get('div#navigators').should('exist')
    .and('have.class','collapse navbar-collapse')

    //set viewport size to smaller screen
    cy.viewport(800,500)
    cy.get('button.navbar-toggler').should('exist')
    .and('be.visible')

    // click toggle button
    cy.get('button.navbar-toggler').should('be.visible').click()
    cy.get('div#navigators').should('have.class','show')
    
    
  })

  it('test first navigation list',()=>{
    // get ul element with class ".navbar-nav"
    cy.get('ul#navigation-1').should('exist')
    .find('li').should('have.length',6)

    // get home navigator
    cy.get('li').find('a#home').should('exist')
    .and('have.class','nav-link')
    .and('have.attr','href','/php_ecommerce/home.php')
    .and('have.text','Home')

    // check a tag after click to have class "active"
    cy.get('a#home').click()
    cy.get('a#home').should('have.class','active')
    

    // check url after clicked on home
    cy.url().should('contain','home.php')

  })

  it('get dropdown category list element and test it', ()=>{
    cy.get('li#dropdown').should('exist')
    .and('have.class','nav-item dropdown')
    .within(()=>{
      // get anchor element with id #navbarDropdown
      cy.get('a#navbarDropdown').should('exist')
      .and('have.class','nav-link dropdown-toggle')
      .and('have.attr','role','button')
      .and('have.attr','data-bs-toggle',"dropdown")
      .and('have.attr','aria-expanded','false')
      

      // get menu list element with id #dropdown-menu
      cy.get('ul#dropdown-menu').should('exist')
      .and('have.class','dropdown-menu')
      .and('have.attr','aria-labelledby','navbarDropdown active')
      .and('not.be.visible')
    })

    // get dropdown menu with all elements in it
    cy.get('ul#dropdown-menu').children('li')
    .should('have.length',4)
    .children('a')
    .should('have.length',4)

    // // click on dropdown menu with id #navbarDropdown and check the menu
    cy.get('li > a#navbarDropdown').click()
    cy.get('a#navbarDropdown')
    .should('have.attr','aria-expanded','true')
    
    // dropdown menu visiblety after click
    cy.get('ul#dropdown-menu').should('be.visible')

    // hide it again
    cy.get('a#navbarDropdown').click()

    // get every single element in dropdown menu
    cy.get('ul#dropdown-menu').within(()=>{
    
      // first li with anchor element with id #men
      cy.get('li > a#men').should('exist')
      .and('have.text','men\'s clothing')
      .and('have.class','dropdown-item')
      .and('have.attr','href','/php_ecommerce/category/men_clothing.php')

      // second li with anchor element with id #jewelery
      cy.get('li > a#jewelery').should('exist')
      .and('have.class','dropdown-item')
      .and('have.text','jewelery')
      .and('have.attr','href','/php_ecommerce/category/jewelery.php')

      // third li with anchor element with id #electronics
      cy.get('li > a#electronics').should('exist')
      .and('have.class','dropdown-item')
      .and('have.text','electronics')
      .and('have.attr','href','/php_ecommerce/category/electronic.php')
      
      // fourth liwith anchor element with id #women
      cy.get('li > a#women').should('exist')
      .and('have.class','dropdown-item')
      .and('have.text','women\'s clothing')
      .and('have.attr','href','/php_ecommerce/category/women_clothing.php')
    })

    // click men's clothing category and check url
    cy.get('a#navbarDropdown').click()  // click the category button
    cy.get('li > a#men').click()
    cy.url().should('contain','category/men_clothing.php')

    // click women's clothing category and check url
    cy.get('a#navbarDropdown').click()  // click the category button
    cy.get('li > a#women').click()
    cy.url().should('contain','category/women_clothing.php')

    // click jewelery  category and check url
    cy.get('a#navbarDropdown').click()  // click the category button
    cy.get('li > a#jewelery').click()
    cy.url().should('contain','category/jewelery.php')

    // click electronics category and check url
    cy.get('a#navbarDropdown').click()  // click the category button
    cy.get('li > a#electronics').click()
    cy.url().should('contain','category/electronic.php')
  })

  it('getting search engin and test it',()=>{

    //check that navbar has form with id #search_engin
    cy.get('div.container-fluid').find('form#search_engin').should('exist')

    // check action and method attribute
    cy.get('#search_engin')
    .should('have.attr','action','/php_ecommerce/home.php')
    .and('have.attr','method','post')

    // get serch input
    cy.get('#search_engin')
    .find('input','[name="search"]')
    .should('exist')

    // get search input attributes
    cy.get('input[name="search"]')
    .should('have.class','form-control')
    .and('have.attr','placeholder','Search mktime')
    .and('have.attr','type','search')
    .and('have.attr','value','')

    //type something and check value
    cy.get('input[name="search"]').type('mktime website')
    .should('have.value','mktime website')

    // get search submit button and test it
    cy.get('#search_engin')
    .find('input[name="search_btn"]')
    .should('exist')

    // get input attributes
    cy.get('input[name="search_btn"]')
    .should('have.attr','type','submit')
    .and('have.class','btn')
    .and('have.value','Search').click()

  })

  it('get the last list in navbar',()=>{
    cy.get('div.container-fluid').find('ul#navbar-list').should('exist')

    cy.get('#navbar-list').find('li').should('have.length',3)

    // get cart element within li element with id #cart-list
    cy.get('#cart-list').should('exist')
    cy.get('#cart-list').find('a').should('exist')
    cy.get('#cart-anchor').should('have.class','nav-link')
    .and('have.attr','href','/php_ecommerce/user/cart.php')
    
    // get icon elemnt with id #cart-list
    cy.get('#cart-list').find('i').should('exist')
    .and('have.class','fa-solid fa-lg fa-cart-shopping')

    // get specified login list with id #login-logout
    cy.get('li#login-logout').should('exist')
    .and('have.class','nav-item text-white')

    // get username list with id #username
    cy.get('li#username').should('exist')
    .and('have.class','nav-item text-white')

  })

})