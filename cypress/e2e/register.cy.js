describe('registered customer cart', () => {

  // before each test visit the following
  beforeEach(()=>{
    cy.visit('http://localhost/php_ecommerce/user/cart.php')
  })

  it('regester a new customer', () => {
    
    //visit regester page
    cy.visit('http://localhost/php_ecommerce/user/signup.php')

    //get username input and type a username
    cy.get('input[name="username"]').should('exist')
    .type('jack')

    //get email input and type an email
    cy.get('input[name="email"]').should('exist')
    .type('jack@gmail.com')

    //get password input and type a password
    cy.get('input[name="password"]').should('exist')
    .type('jack1234')

    //get confirm_password input and type a confirm_password
    cy.get('input[name="confirm_password"]').should('exist')
    .type('jack1234')

    // get and click submit button
    cy.get('button[name="signup_btn"]').should('exist').click()
    
    // check url after failed should contain signup.php
    cy.url().then(url=>{
      if(url.includes('signup.php')){
        // reloade the page to set session
        cy.reload()
        
        // get message
        cy.get('#signup_message').should('contain','A User account with that username/email already exist try login or use a different username/email to register.')
        .and('be.visible')

      }

      // check url aftr success should contain login.php
      cy.url().then(url=>{
        if(url.includes('login.php')){

        // get success message
        cy.get('#success_message').should('exist')
        .and('be.visible')
        .and('contain','YOU signed up successfully')

        }
        })
    })
    
  })

})