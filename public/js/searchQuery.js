document.getElementById("searchButton").addEventListener("click", function () {
  var searchInput = document.getElementById('searchQuery');
  suggestionList.style.display = 'none';
  var searchQuery = searchInput.value;
  var now = new Date();
  var time = now.getTime();
  time += 300000;
  now.setTime(time);


  var ajax = new XMLHttpRequest();
  ajax.open("GET", "http://localhost/pharmacy-management-system/controllers/ajax/searchQuizzes.inc.php?searchQuery=" + encodeURIComponent(searchQuery) + "&isSearchBtn", true);
  ajax.onreadystatechange = function () {
    if (ajax.readyState === 4 && ajax.status === 200) {
      var response = JSON.parse(ajax.responseText);
      var quizzes = response.quizzes;
      var container = document.getElementById("mainContainer");

      container.innerHTML = "";

      quizzes.forEach(function (quiz) {
        var card = document.createElement("div");
        card.classList.add("card", "mb-3", "mt-3");
        card.innerHTML = `
          <div class="row">
            <div class="col-md-3">
                <img src="https://cdn.shopify.com/s/files/1/0566/6586/6400/products/6_6e504cd6-25a9-46b2-b94b-5d87768d3306_300x@2x.jpg?v=1629388839" alt="" class="img-fluid h-100 w-100">
            </div>
            <div class="col-md-8 mt-5">
              <div class="card-body">
                  <h3 class="card-title">${quiz.title}</h3>
                  <h4 class="card-title">Created By: ${quiz.username}</h4>
                  <a href="/pharmacy-management-system/quiz/viewQuiz.php?quizId=${quiz.quizid}" class="btn mt-5 btn-primary">View Quiz Details</a>
              </div>
            </div>
          </div>
              `;
        container.appendChild(card);
      });
    }
  };
  ajax.send();

});

var searchInput = document.getElementById('searchQuery');
var suggestionList = document.getElementById('suggestionList');
var currentSelectionIndex = -1;

function fetchSuggestions(searchQuery) {
  var ajax = new XMLHttpRequest();
  ajax.open('GET', 'http://localhost/pharmacy-management-system/controllers/ajax/searchQuizzes.inc.php?searchQuery=' + encodeURIComponent(searchQuery), true);
  ajax.setRequestHeader('Content-Type', 'application/json');

  ajax.onreadystatechange = function () {
    if (ajax.readyState === 4 && ajax.status === 200) {
      var response = JSON.parse(ajax.responseText);
      var suggestions = response.quizzes;
      var noResultsMessage = document.getElementById('noResultsMessage');

      if (searchQuery === '') {
        suggestionList.style.display = 'none';
        suggestionList.innerHTML = '';
        noResultsMessage.style.display = 'none';
        return;
      }

      if (suggestions.length > 0) {
        suggestionList.style.display = 'block';
        suggestionList.innerHTML = '';
        noResultsMessage.style.display = 'none';

        suggestions.forEach(function (suggestion, index) {
          var suggestionItem = document.createElement('a');
          suggestionItem.href = '/pharmacy-management-system/quiz/viewQuiz.php?quizId=' + suggestion.quizid;
          suggestionItem.classList.add('suggestion-item');
          suggestionItem.textContent = suggestion.title;

          suggestionItem.addEventListener('mouseover', function () {
            this.classList.add('hovered');
          });

          suggestionItem.addEventListener('mouseout', function () {
            this.classList.remove('hovered');
          });

          suggestionList.appendChild(suggestionItem);
        });

        currentSelectionIndex = -1;
      } else {
        suggestionList.style.display = 'none';
        noResultsMessage.style.display = 'block';
      }
    }
  };
  ajax.send();
}

function handleKeyboardNavigation(event) {
  var suggestions = suggestionList.getElementsByClassName('suggestion-item');
  var suggestionsCount = suggestions.length;

  if (event.key === 'ArrowDown') {
    currentSelectionIndex = Math.min(currentSelectionIndex + 1, suggestionsCount - 1);
    event.preventDefault();
  } else if (event.key === 'ArrowUp') {
    currentSelectionIndex = Math.max(currentSelectionIndex - 1, -1);
    event.preventDefault();
  }

  for (var i = 0; i < suggestionsCount; i++) {
    suggestions[i].classList.remove('hovered');
  }

  if (currentSelectionIndex !== -1) {
    suggestions[currentSelectionIndex].classList.add('hovered');
    suggestions[currentSelectionIndex].scrollIntoView({ block: 'nearest' });
  }

  if (event.key === 'Enter' && currentSelectionIndex !== -1) {
    var selectedSuggestion = suggestions[currentSelectionIndex];
    window.location.href = selectedSuggestion.href;
  }
}

searchInput.addEventListener('input', function (event) {
  var searchQuery = event.target.value.trim();
  fetchSuggestions(searchQuery);
});

searchInput.addEventListener('keydown', handleKeyboardNavigation);