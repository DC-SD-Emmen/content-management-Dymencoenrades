const pizza = document.getElementById('pizza');

pizza.addEventListener('wheel', (event) => {
    event.preventDefault(); // Prevent default scroll behavior
    pizza.scrollLeft += event.deltaY; // Scroll horizontally based on vertical scroll
});


 // Frame Opener
 const div = document.getElementById('myForm');
 let plusknop = document.getElementById('plusimage');

 plusknop.addEventListener('click', function() {
      // Toggle display between 'block' and 'none'
     if (div.style.display == 'none') {
         div.style.display = 'block'; // Show the div
     } else {
         div.style.display = 'none';  // Hide the div
     }
 })
// Frame Opener


const elements = document.getElementsByClassName("bg_image");

Array.from(elements).forEach(element => {
    element.addEventListener("click", function() {
        const DetailpageDiv = document.getElementById("Detailpage");
        const parentElement = element.parentElement; // Get the parent of the bg_image
        const descriptionDiv = parentElement.querySelector(".description_div");
        const genreDiv = parentElement.querySelector(".genre_div");
        const platformDiv = parentElement.querySelector(".platform_div");
        const releaseyearDiv = parentElement.querySelector(".release_year_div");
        const ratingDiv = parentElement.querySelector(".rating_div");
        

        if (DetailpageDiv) {
            DetailpageDiv.style.display = 
            DetailpageDiv.style.display === 'none' ? 'block' : 'none';
            DetailpageDiv.querySelector(".DetailPage_Description").innerText = descriptionDiv.innerText;
            DetailpageDiv.querySelector(".DetailPage_Genre").innerText = genreDiv.innerText;
            DetailpageDiv.querySelector(".DetailPage_Platform").innerText = platformDiv.innerText;
            DetailpageDiv.querySelector(".DetailPage_ReleaseYear").innerText = releaseyearDiv.innerText;
            DetailpageDiv.querySelector(".DetailPage_Rating").innerText = ratingDiv.innerText;
        }
    });
});


  