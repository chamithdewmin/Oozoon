(function () {
  "use strict";

  let forms = document.querySelectorAll('.php-email-form');

  forms.forEach(function (form) {
    form.addEventListener('submit', function (event) {
      event.preventDefault();
      const action = form.getAttribute('action');
      const loading = form.querySelector('.loading');
      const errorMsg = form.querySelector('.error-message');
      const successMsg = form.querySelector('.sent-message');

      loading.style.display = 'block';
      errorMsg.style.display = 'none';
      successMsg.style.display = 'none';

      const formData = new FormData(form);

      fetch(action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(response => response.text())
      .then(data => {
        loading.style.display = 'none';
        if (data.trim() === 'OK') {
          successMsg.style.display = 'block';
          form.reset();
        } else {
          throw new Error(data);
        }
      })
      .catch(error => {
        loading.style.display = 'none';
        errorMsg.textContent = error.message;
        errorMsg.style.display = 'block';
      });
    });
  });
})();
