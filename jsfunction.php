<?php
//session_start();
//isLogin
function isLoggedIn() {
    return isset($_SESSION['user_id']); // Adjust the session variable name as needed
}

?>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="loginForm">
                <input type="hidden" id="encodedpassData" name="encodedpassData" value="<?php echo $encodedpassData; ?>">
                <input type="hidden" id="loginButtonId" name="loginButtonId" value="">
                        
                <div class="form-group">
                        <label for="loginEmail">Email</label>
                        <input type="email" class="form-control" id="loginEmail" name="loginEmail" required max="25">
                    </div>
                    <div class="form-group">
                        <label for="loginPassword">Password</label>
                        <input type="password" class="form-control" id="loginPassword" name="loginPassword" required maxlength="10">
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
                <p class="mt-3">New customer? <a href="#" id="registerLink">Register here</a></p>
            </div>
        </div>
    </div>
</div>

<!--login modal close-->
<!--Register modal open -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Register</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="registerForm" action="" method="post">
                <input type="hidden" name="encodedpassData" value="<?php echo $encodedpassData; ?>">
                    <div class="form-group">
                        <label for="registerName">Name</label>
                        <input type="name" class="form-control" id="registerName" name="registerName" required maxlength="25">
                    </div>
                    <div class="form-group">
                        <label for="registerEmail">Email</label>
                        <input type="email" class="form-control" id="registerEmail" name="registerEmail" required maxlength="25">
                    </div>
                    <div class="form-group">
                        <label for="registerPassword">Password</label>
                        <input type="password" class="form-control" id="registerPassword" name="registerPassword" required maxlength="10">
                    </div>
                    <div class="form-group">
                        <label for="registerAddress">Address</label>
                        <textarea class="form-control" id="registerAddress" name="registerAddress" rows="4" required maxlength="50"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">SAVE</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Register modal close -->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Show the login modal when Proceed to Payment is clicked
    $("#proceedToPaymentBtn, #proceedToPaymentBtn2").on("click", function() {

        var clickedButtonId = $(this).attr("id");

        // Now you can use the clickedButtonId to perform specific actions based on the clicked button.
        if (clickedButtonId === "proceedToPaymentBtn") {
            // Code for #proceedToPaymentBtn clicked
                $("#loginButtonId").val(clickedButtonId);
        } else if (clickedButtonId === "proceedToPaymentBtn2") {
            // Code for #proceedToPaymentBtn2 clicked
                $("#loginButtonId").val(clickedButtonId);
        }

        if (!isLoggedIn()) {
            // If not logged in, show the login modal
            $("#loginModal").modal("show");
        } else {
            // If logged in, proceed to payment
            var encodedpassData = $("#encodedpassData").val();
            
            redirectToPayment(encodedpassData);
        }
    });

    // Handle the login form submission
    $("#loginForm").on("submit", function(e) {
        e.preventDefault();
        var email = $("#loginEmail").val();
        var password = $("#loginPassword").val();
        var encodedpassData = $("#encodedpassData").val();

        // Make an AJAX request to validate login
        $.post("login_process.php", {
            email: email,
            password: password
        }, function(data) {
            if (data === "success") {
                // Login successful, close modal and proceed to payment
                $("#loginModal").modal("hide");
                redirectToPayment(encodedpassData);
            } else {
                alert('Wrong Credentials');
            }
        });
    });

    function isLoggedIn() {
        // Implement your logic to check if the user is logged in
        // Return true if logged in, false otherwise
        // Example: return sessionStorage.getItem("userLoggedIn") === "true";
        return <?php echo isLoggedIn() ? 'true' : 'false'; ?>;
    }

    function redirectToPayment(encodedpassData) {
        if (encodedpassData) {
    
            var queryParams = $.param({
                encodedpassData: encodedpassData // Include your other query parameters here
            });

            // Redirect to the payment page with query parameters
            if ($("#loginButtonId").val() == "proceedToPaymentBtn") {
            // Code for #proceedToPaymentBtn clicked
                window.location.href = "payment_process.php?" + queryParams;
            } else if ($("#loginButtonId").val() == "proceedToPaymentBtn2") {
                // Code for #proceedToPaymentBtn2 clicked
                window.location.reload();
            }
            
            
        }
    }


     // Show the register modal 
     $("#registerLink").on("click", function() {
        $("#registerModal").modal("show");
        $("#loginModal").modal("hide");
    });

    // Handle the registration form submission using AJAX
    $("#registerForm").on("submit", function(e) {
    e.preventDefault();

    // Get form input values
    var registerName = $("#registerName").val();
    var registerEmail = $("#registerEmail").val();
    var registerPassword = $("#registerPassword").val();
    var registerAddress = $("#registerAddress").val();

    // Reset any previous error messages
    $(".error-message").remove();

    // Validate Name (not empty)
    if (registerName === "") {
        $("#registerName").after('<p class="text-danger error-message">Name is required</p>');
        return; // Prevent form submission
    }

    // Validate Email (not empty and valid email format)
    if (registerEmail === "" || !isValidEmail(registerEmail)) {
        $("#registerEmail").after('<p class="text-danger error-message">Valid email is required</p>');
        return; // Prevent form submission
    }

    // Validate Password (not empty and at least 6 characters)
    if (registerPassword === "" || registerPassword.length < 6) {
        $("#registerPassword").after('<p class="text-danger error-message">Password must be at least 6 characters</p>');
        return; // Prevent form submission
    }

    // Validate Address (not empty)
    if (registerAddress === "") {
        $("#registerAddress").after('<p class="text-danger error-message">Address is required</p>');
        return; // Prevent form submission
    }

    // If all validations pass, submit the form
    submitForm();
});

// Function to check if the email is in a valid format
function isValidEmail(email) {
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return emailPattern.test(email);
}

// Function to submit the form (assuming all validations passed)
function submitForm() {
    // Serialize the form data
    var formData = $("#registerForm").serialize();

    $.ajax({
        type: "POST",
        url: "register.php", // Change this to the appropriate URL
        data: formData,
        success: function(response) {
            // Handle the response from the server
            if (response === "success") {
                // Registration successful, you can display a success message
                console.log("Registration successful");
                // Reloads the current page
                location.reload();
                // Optionally, close the modal or take other actions
            } else {
                // Registration failed, you can display an error message
                console.log("Registration failed");
                // Optionally, display an error message to the user
                // Reloads the current page
                location.reload();
            }
        }
    });
}

});
</script>