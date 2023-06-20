<script>
function loadNumberOfCards(numberOfCardsToLoad) {   
    var request = new XMLHttpRequest();
    request.open('GET', "logic/CardFetcher.php?numberOfCards=" + numberOfCardsToLoad, true);
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            var cardspage = document.getElementById("cardspage");
            var cardsToLoad = request.responseText;
            console.log(cardsToLoad);
            cardspage.insertAdjacentHTML('beforeend', cardsToLoad);
        }
    };
    request.send();
}

function handleInfiniteScroll() {
    var endOfPage = window.innerHeight + window.pageYOffset >= document.body.offsetHeight;

    if (endOfPage) {;
        loadNumberOfCards(15);
    }
}

window.onload = function () {
    loadNumberOfCards(3);
};

window.addEventListener("scroll",(event) => {handleInfiniteScroll()});
</script>
