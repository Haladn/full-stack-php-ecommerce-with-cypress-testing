describe('update cart items quantity', () => {
  // before each test do the following
  beforeEach(()=>{
    // use custom command to login defined in cypress support folder in commands.js
    cy.login('jack@gmail.com','jack1234')

    // check cart item number if zero then add some item
     cy.get('#cart-icon').then(cartValue=>{
      if(cartValue.text() < 5){    // text() is a jQuery function
        // add some item to customer cart
        cy.get('button.home-btn').first().click()
        cy.get('button.home-btn').last().click()
      }
    })

    //back to cart page
    cy.visit('https://localhost/php_ecommerce/user/cart.php')
  })
  it('updating an first item quantity then check cart quantity',()=>{
  
    // update first item quantity
    cy.get('.cart-form-quantity').first().then($el=>{
      //clear value
      cy.get('.cart-form-quantity').first().clear()

      // type new value of 3
      cy.get('.cart-form-quantity').first().type(3)

      // // then submit update button of first item
      cy.get('button[name="update_btn"]').first().click() 
    })

     // check cart item quantity and compare it to total quantity
     cy.get('#cart-icon').then($el=>{
      cy.get('#cart-total-quantity > span').then($total=>{
        expect($el.text().trim()).to.eq($total.text().trim())
      })
    })

    // get toal quantity and compare it with sum up of item quantities
    cy.get('#cart-total-quantity > span').then($el=>{
      // sum up item quantity values
      let sumQuantity = 0;

      //get first item quantity and add its value to values variable
      cy.get('.cart-form-quantity').first().should($input=>{
          sumQuantity += parseInt($input.val(), 10);
      }).then(()=>{
        //get last item quantity and add its value to values variable
        cy.get('.cart-form-quantity').last().should($input=>{
          sumQuantity += parseInt($input.val(), 10);

          expect($el.text().trim()).to.eq(sumQuantity.toString())
        })
      })
    })

    // get toal price and compare it with sum up of item prices
    cy.get('#cart-total-price > span').then($el=>{
      const totalPrice = parseFloat($el.text().trim());
      // store total price
      let sumUpPrices = 0;
      // get first item price
      cy.get('.cart-price').first().then($firstEl=>{
        sumUpPrices +=parseFloat($firstEl.text().trim())
      }).then(()=>{
        // get secont item price
        cy.get('.cart-price').last().then($lastEl=>{
          sumUpPrices += parseFloat($lastEl.text().trim())

          expect(totalPrice.toString()).to.eq(sumUpPrices.toFixed(2))
        })
      })
    })

  })

 


})