describe('delete item', () => {
  it('check view and delete button', () => {
  
    // use custom command to login defined in cypress support folder in commands.js
    cy.login('jack@gmail.com','jack1234')

    // add some item
    cy.get('#cart-icon').then(()=>{
      // add some item to customer cart
      cy.get('button.home-btn').first().click()
      cy.get('button.home-btn').last().click()
 
    })

    
    //back to cart page
    cy.visit('https://localhost/php_ecommerce/user/cart.php')

      // get second item view buutton and click on it
      cy.get('a[name="cart-view-link"]').last().should('exist')
      .click()
  
      //check url that should contain view.php and id=item_id
      cy.url().should('contain','view.php')
  
      // get and click on cart to back to cart page
      cy.get('#cart-icon').click()
  
      // get and test delete button on first item
      cy.get('button[name="delete_btn"]').first().click()

      
    
  })
})