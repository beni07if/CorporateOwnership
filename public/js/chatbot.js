// File: public/js/chatbot.js

// Wait until the DOM is ready
$(document).ready(function() {
  // Select the chat form element
  var chatForm = $('#chat-form');

  // Listen for the form submit event
  chatForm.submit(function(event) {
    // Prevent the default form submission
    event.preventDefault();

    // Send the chat message to the server
    $.ajax({
      type: 'POST',
      url: '/chatbot',
      data: {
        '_token': $('input[name=_token]').val(),
        'message': $('#chat-message').val()
      },
      success: function(response) {
        // Display the response from the server
        $('#chat-history').append('<li>' + response + '</li>');
      },
      error: function() {
        // Display an error message if the request fails
        alert('Failed to send message!');
      }
    });

    // Clear the chat input field
    $('#chat-message').val('');
  });
});
