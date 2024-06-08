describe('checking cart items number with cart content', () => {

   // before each test visit the following
   beforeEach(()=>{
    cy.visit('http://localhost/php_ecommerce/user/cart.php')
  })
  it('get login element and click on it', () => {
    cy.get('#login-logout').find('a#login-anchor')
    .should('exist')
    .and('have.class','nav-link')
    .and('have.attr','href','/php_ecommerce/user/login.php')
    .and('contain','Login').click()
    
    //check url that should contain "login.php"
    cy.url().should('contain','login.php')

  })

  it('check content page while cart has zero item in it for unregistered user',()=>{
    cy.get('i#cart-icon').should('contain',0)
    cy.get('#unregisterd-no-item').should('exist')
    .and('contain','There is no Item in your Cart')
  })

  it('adding item to the cart and check content for unregistered user',()=>{
  
    // send post request to set session using the PHP endpoin
    cy.request(
      {
        method:'POST',
        url:'http://localhost/php_ecommerce/test_file/set_session.php',
      body:{
        cart:{
          3:{
            title:'White Rider Analog Watch at 2:12 Time',
            price:'499.00',
            in_cart_quantity:1,
            in_stock_quantity:10,
            image:'http://localhost/php_ecommerce/test_file/watch.jpg'
          },
        },
        cart_message:'added to the cart'
      },
      form: true //  to convert the body values to URL encoded content
      
    }).then((response)=>{
      expect(response.status).to.equal(200);
      expect(response.body).to.have.property('status','success')
    })

    // reloading the page to apply session changes
    cy.reload()

    //check cart number value to be 1
    cy.get('#cart-icon').should('contain',1)

    // check added to the cart message 
    cy.get('#cart-message').should('exist')
    .and('contain','added to the cart')

    // check the total container content
    // get total product element
    cy.get('#unregistered-total-container').should('exist')
    .find('#unregistered-total-product').should('exist')
     
    // check total product
    cy.get('#unregistered-total-product').should('have.text','Total Products: 1')

    // get and check total price content
    cy.get('#unregistered-total-price').should('exist')
    .and('contain','Total Price:')
    .and('contain','£')

    // get and check checkout form
    cy.get('#unregistered-total-form').should('exist')
    .and('have.attr','action','../tools/checkout.php')
    .and('have.attr','method','POST')

    // get input elements and check them
    //first input
    cy.get('#unregistered-total-form').find('[name="total_quantity"]')
    .should('exist')
    
    cy.get('[name="total_quantity"]').should('have.attr','type','text')
    .and('be.hidden')
    .and('have.attr','value')
    
    // to check it has a value
    cy.get('[name="total_quantity"]').invoke('val')
    

    //second input
    cy.get('#unregistered-total-form').find('[name="total_price"]')
    .should('exist')

    cy.get('[name="total_price"]').should('have.attr','type','text')
    .and('be.hidden')
    .and('have.attr','value')

    // to check it has a value
    cy.get('[name="total_price"]').invoke('val')
    
    // get and check checkout button
    cy.get('#unregistered-total-form').find('[name="total_checkout_btn"]').should('exist')
    
    cy.get('[name="total_checkout_btn"]').should('have.text','Checkout')
    .and('have.attr','type','submit')
    .and('have.class','btn').click()

    // check url that include checkout.php
    cy.url().should('contain','checkout.php')

    // back to the cart page
    cy.visit('http://localhost/php_ecommerce/user/cart.php')

    // check item content
    cy.get('#unregistered-user-items').should('exist')
    .find('#unregistered-row').should('exist')

    // chech row container with id #unregister-row
    cy.get('#unregistered-row').should('have.class','row')
    .find('img#unregistered-item-image').should('exist')

    //check img element and its attribute
    cy.get('#unregistered-item-image')
    .should('have.class','img-fluid')
    .and('have.attr','src','http://localhost/php_ecommerce/test_file/watch.jpg')
    .and('have.attr','alt','White Rider Analog Watch at 2:12 Time')

    //get col container with id #unregistered-col with its children
    cy.get('#unregistered-row').children('#unregistered-col')
    .should('exist')
    .and('have.class','col-md-8')
    .children('#unregestered-flex').should('exist')
    .and('have.class','d-flex flex-column justify-content-between')

    // get and check d-flex children elements
    // get title container and check it
    cy.get('#unregestered-flex').within(()=>{
      cy.get('#unregistered-item-title').should('exist')
      .and('have.class','card-title fw-bold')
      .and('have.text','White Rider Analog Watch at 2:12 Time')

      // get price container and check it
      cy.get('#unregistered-item-price').should('exist')
      .and('contain','Price: £')

      // get ithe item form
      cy.get('div').find('form#unregistered-item-form').should('exist')
      cy.get('form#unregistered-item-form').as('form')

      // get all form input and button elements and check there content
      
      //get item quantity input
      cy.get('@form').find('input[name="item_quantity"]').should('exist')
      .and('have.attr','type','number')
      .and('have.attr','max','10') // set in session
      .and('have.attr','min','1') // default value
      .and('have.value','1') // set in session

      //get item id input
      cy.get('@form').find('input[name="item_id"]').should('exist')
      .and('have.attr','type','text')
      .and('have.value','3') //set in session
      .and('be.hidden')

      // get item price input
      cy.get('@form').find('input[name="item_price"]').should('exist')
      .and('have.attr','type','text')
      .and('have.value','499.00') // set in session
      .and('be.hidden')

      // get update button
      cy.get('@form').find('button[name="update_btn"]').should('exist')
      .and('have.attr','type','submit')
      .and('have.text','update')
      .and('have.class','btn btn-sm btn-warning mb-1')

      // get delete button
      cy.get('@form').find('button[name="delete_btn"]').should('exist')
      .and('have.attr','type','submit')
      .and('have.text','delete')
      .and('have.class','btn btn-sm btn-danger mb-1')

      // get view button
      cy.get('@form').find('a#item-view-lin').should('exist')
      .and('have.attr','href','../view.php?id=3') // id set in session
      .and('have.text','view')
      .and('have.class','btn btn-sm btn-info mb-1')

      // stop out of #unregestered-flex container
    })

     // click on view button
     cy.get('a#item-view-lin').click() // then check url
     cy.url().should('include','view.php')
     .and('include','id=3')

     // back to cart page
     cy.visit('http://localhost/php_ecommerce/user/cart.php')

     // increment the quantity then click update 
     cy.get('input[name="item_quantity"]')
     .clear() // revove current value
     .type(3) // put new value
     .should('have.value','3')

     // then click update button to apply changes
     cy.get('button[name="update_btn"]').click()

     //check total product value that must be updated
     cy.get('#unregistered-total-product > span').should('have.text',3)

     // check cart item nubers that musbe updated
     cy.get('#cart-icon').should('contain',3)

     // check total price that must be updated
     const quantity = 3;
     const price = 499.00;
     const total_price = (quantity * price).toLocaleString() + ".00";
     cy.get('#unregistered-total-price > span')
     .should('contain',total_price)

     // check item price that must be updated
     cy.get('#unregistered-item-price > span').should('have.text',total_price)

     // click on delete button
     cy.get('#unregistered-item-form')
     .find('button[name="delete_btn"]').click()

     // check cart's items number
     cy.get('#cart-icon').should('contain',0)

     cy.get('#unregisterd-no-item').should('be.visible')
     .and('have.text','There is no Item in your Cart.')

  })

})