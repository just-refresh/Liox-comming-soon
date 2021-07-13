var consoleSignatureStyle = "font-size: 16px;" +
  "background: linear-gradient(to right, #0044FF, #00C3FF);" +
  "color: white;" +
  "text-align: center;" +
  "padding: 10px 15px;" +
  "margin-top: 10px;" +
  "width: 100%;" +
  "border-radius: 8px;";

var consoleSignatureText = "%cNice to see you here! 👋 \n Your love to Code and work on great Ideas? \n We're always searching 🕵️ for advise 💁🏻, feedback 💡 or more Power 💪 for our great Team! 🏘️ \n 📥 Just get in contact: hello@liox.io";

console.log(consoleSignatureText, consoleSignatureStyle);


var subscribe_button = document.querySelector(".subscribe_button");

subscribe_button.addEventListener('click', function(){
	var subscribing = document.querySelector(".subscribing");
	var thanks = document.querySelector(".thanks");
	var login = document.querySelector(".login");

	subscribing.classList.add("subscribing_active");
	subscribe_button.classList.add("subscribe_button_active");
	setTimeout(function(){
		login.classList.add("login_active");
	}, 1200);
	setTimeout(function(){
		thanks.classList.add("thanks_active");
	}, 1400);

	setTimeout(function(){
		thanks.classList.remove("thanks_active");
		login.classList.remove("login_active");
		subscribing.classList.remove("subscribing_active");
		subscribe_button.classList.remove("subscribe_button_active");
	}, 4000);
});
