    document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const cartForms = document.querySelectorAll('form.add-to-cart');

    cartForms.forEach(form => {
        form.addEventListener('submit', function (event) {
             event.preventDefault();
            const formData = new FormData(form);
            fetch('add_to_cart.php', {
                method: 'POST',
                 body: formData
             })
            .then(response => {
                if(!response.ok){
                 throw new Error('Ошибка сети');
              }
            return response.json();
            })
            .then(data => {
                console.log('Server response:', data);
                const cartCounter = document.querySelector('.cart-counter');
                if (cartCounter) {
                 if (data.cartCount > 0) {
                        cartCounter.textContent = data.cartCount;
                       cartCounter.style.display = 'inline-block';
                     } else {
                         cartCounter.textContent = 0;
                       cartCounter.style.display = 'none';
                   }
                }
            })
           .catch(error => {
             console.error('Fetch error:', error);
             });
        });
    });
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(event){
            event.preventDefault();
            const formData = new FormData(loginForm);
            fetch('login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if(data.includes("успешно")){
                    const modal = loginForm.closest('.modal');
                    const bsModal = bootstrap.Modal.getInstance(modal);
                    bsModal.hide();
                    window.location.href = 'index.php';
                }else{
                    const modalBody = loginForm.closest('.modal-body');
                    modalBody.innerHTML = `<p class="err-msg">${data}</p>` + modalBody.innerHTML;
                }
            });
        });
    }

    const registerForm = document.getElementById('registerForm');
    if(registerForm){
        registerForm.addEventListener('submit', function(event){
            event.preventDefault();
            const formData = new FormData(registerForm);
            fetch('register.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if(data.includes("успешно")){
                    const modal = registerForm.closest('.modal');
                    const bsModal = bootstrap.Modal.getInstance(modal);
                    bsModal.hide();
                    window.location.href = 'index.php';
                }else{
                    const modalBody = registerForm.closest('.modal-body');
                    modalBody.innerHTML = `<p class="err-msg">${data}</p>` + modalBody.innerHTML;
                }
            });
        });
    }
});
   function applyFilter() {
     const sort = document.getElementById('sort').value;
     const category = document.getElementById('category').value;
    const params = new URLSearchParams(window.location.search);
     params.set('sort', sort);
       params.set('category',category)
    window.location.href = 'search.php?' + params.toString();
  };
  