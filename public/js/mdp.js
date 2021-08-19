let passwordConfirm = document.getElementById('registration_form_confirmPassword');
let password = document.getElementById('registration_form_plainPassword');

let editpassword1 = document.getElementById('user_edit_plainPassword');
let editpassword2 = document.getElementById('user_edit_confirmPassword');


if (passwordConfirm != null) {
    passwordConfirm.addEventListener('change', function(e) {
        if (password.value != passwordConfirm.value) {
            document.getElementById('alerte_mdp').innerHTML = "erreur les mot des passes ne correspondent pas";
            document.getElementById("submit").disabled = true;
            // document.getElementById("submit").className = "w-5/12 self-center bg-gray-500 hover:bg-gray-700 text-white  mt-4 py-1 rounded"
            document.getElementById("submit").classList.remove("bg-purple-500", "hover:bg-purple-700")
            document.getElementById("submit").classList.add("bg-gray-500", "hover:bg-gray-700")
        } else {
            document.getElementById('alerte_mdp').innerHTML = "";
            document.getElementById("submit").disabled = false;
            // document.getElementById("submit").className = "w-5/12 self-center bg-purple-500 hover:bg-purple-700 text-white  mt-4 py-1 rounded";
            document.getElementById("submit").classList.remove("bg-gray-500", "hover:bg-gray-700")
            document.getElementById("submit").classList.add("bg-purple-500", "hover:bg-purple-700")
        }
    })
    password.addEventListener('change', function(e) {
        if (passwordConfirm.value.length > 0) {
            if (password.value != passwordConfirm.value) {
                document.getElementById('alerte_mdp').innerHTML = "erreur les mot des passes ne correspondent pas";
                document.getElementById("submit").disabled = true;
                // document.getElementById("submit").className = "w-5/12 self-center bg-gray-500 hover:bg-gray-700 text-white  mt-4 py-1 rounded"
                document.getElementById("submit").classList.remove("bg-purple-500", "hover:bg-purple-700")
                document.getElementById("submit").classList.add("bg-gray-500", "hover:bg-gray-700")
            } else {
                document.getElementById('alerte_mdp').innerHTML = "";
                document.getElementById("submit").disabled = false;
                // document.getElementById("submit").className = "w-5/12 self-center bg-purple-500 hover:bg-purple-700 text-white  mt-4 py-1 rounded";
                document.getElementById("submit").classList.remove("bg-gray-500", "hover:bg-gray-700")
                document.getElementById("submit").classList.add("bg-purple-500", "hover:bg-purple-700")
            }
        }
    })

} else {
    editpassword2.addEventListener('change', function(e) {
        if (editpassword1.value != editpassword2.value) {
            document.getElementById('alerte_mdp').innerHTML = "erreur les mot des passes ne correspondent pas";
            document.getElementById("submit").disabled = true;
            // document.getElementById("submit").className = "w-5/12 self-center bg-gray-500 hover:bg-gray-700 text-white  mt-4 py-1 rounded"
            document.getElementById("submit").classList.remove("bg-purple-500", "hover:bg-purple-700")
            document.getElementById("submit").classList.add("bg-gray-500", "hover:bg-gray-700")
        } else {
            document.getElementById('alerte_mdp').innerHTML = "";
            document.getElementById("submit").disabled = false;
            // document.getElementById("submit").className = "w-5/12 self-center bg-purple-500 hover:bg-purple-700 text-white  mt-4 py-1 rounded";
            document.getElementById("submit").classList.remove("bg-gray-500", "hover:bg-gray-700")
            document.getElementById("submit").classList.add("bg-purple-500", "hover:bg-purple-700")
        }
    })

    editpassword1.addEventListener('change', function(e) {
        if (editpassword2.value.length > 0) {
            if (editpassword1.value != editpassword2.value) {
                document.getElementById('alerte_mdp').innerHTML = "erreur les mot des passes ne correspondent pas";
                document.getElementById("submit").disabled = true;
                // document.getElementById("submit").className = "w-5/12 self-center bg-gray-500 hover:bg-gray-700 text-white  mt-4 py-1 rounded"
                document.getElementById("submit").classList.remove("bg-purple-500", "hover:bg-purple-700")
                document.getElementById("submit").classList.add("bg-gray-500", "hover:bg-gray-700")
            } else {
                document.getElementById('alerte_mdp').innerHTML = "";
                document.getElementById("submit").disabled = false;
                // document.getElementById("submit").className = "w-5/12 self-center bg-purple-500 hover:bg-purple-700 text-white  mt-4 py-1 rounded";
                document.getElementById("submit").classList.remove("bg-gray-500", "hover:bg-gray-700")
                document.getElementById("submit").classList.add("bg-purple-500", "hover:bg-purple-700")
            }
        }
    })


}