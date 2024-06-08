
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })

Cypress.Commands.add('login',(email,password)=>{
    cy.visit('https://localhost/php_ecommerce/user/login.php')
    
    // get email input and type jack@gmail.com
    cy.get('form > input#email').should('exist')
    cy.get('form > input#email').type('jack@gmail.com')

    // get password input and type "jack1234"
    cy.get('form > input#password').should('exist')
    cy.get('form > input#password').type('jack1234')

    // // get submit button and click on it
    cy.get('form > button[type="submit"]').should('exist').click()
})