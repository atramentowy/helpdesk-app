function test() {
  alert("Działa z pliku JS!");
}

function showForm(id) {
  const message = document.getElementById("message");
  if (message) {
      message.textContent = ""; // czyści komunikat
  }

  const forms = document.querySelectorAll('.form');

  forms.forEach(form => {
    form.classList.add('hidden'); // show everything
  });

  document.getElementById(id).classList.remove('hidden'); // show one
}

function showDiv(id) {
    document.querySelectorAll('.section').forEach(div => {
        div.classList.add('hidden');
    });

    document.getElementById(id).classList.remove('hidden');
}