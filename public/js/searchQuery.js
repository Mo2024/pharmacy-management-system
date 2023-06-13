var searchInput = document.getElementById('searchQuery');
var suggestionList = document.getElementById('suggestionList');
var currentSelectionIndex = -1;

function fetchSuggestions(searchQuery) {
  var ajax = new XMLHttpRequest();
  ajax.open('GET', 'http://localhost/pharmacy-management-system/controllers/ajax/searchProducts.inc.php?searchQuery=' + encodeURIComponent(searchQuery), true);
  ajax.setRequestHeader('Content-Type', 'application/json');

  ajax.onreadystatechange = function () {
    if (ajax.readyState === 4 && ajax.status === 200) {
      var response = JSON.parse(ajax.responseText);
      var suggestions = response.products;
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
          suggestionItem.href = '/pharmacy-management-system/products/product.php?productId=' + suggestion.pid;
          suggestionItem.classList.add('suggestion-item');
          suggestionItem.textContent = suggestion.name;

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