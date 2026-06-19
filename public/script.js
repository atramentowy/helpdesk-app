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

function showEdit(btn, id) {
	showDiv(id);
	document.getElementById("id").value = btn.dataset.id;
	document.getElementById("title").value = btn.dataset.title;
	document.getElementById("description").value = btn.dataset.description;
	
	document.querySelector("input[name='user_id']").value = btn.dataset.user_id;
	// document.getElementById("user_id").value = btn.dataset.user_id;
	document.getElementById("assigned_to").value = btn.dataset.assigned_to;
	document.getElementById("status").value = btn.dataset.status;
	document.getElementById("priority").value = btn.dataset.priority;
	document.getElementById("created_at").value = btn.dataset.created_at;
}

function showUserEdit(btn, id) {
	showDiv(id);

	// document.querySelector("input[name='user_id']").value = btn.dataset.user_id;
	document.getElementById('edit_user_id').value = btn.dataset.user_id;
	document.getElementById('edit_login').value = btn.dataset.login;
	document.getElementById('edit_password').value = "";
	document.getElementById('edit_email').value = btn.dataset.email;
	document.getElementById('edit_role').value = btn.dataset.role;
}

function showUserDel(btn, id) {
	showDiv(id);
	document.querySelector("input[name='_user_id']").value = btn.dataset.user_id;
	document.getElementById('del_login').value = btn.dataset.login;
}
