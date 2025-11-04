document.addEventListener('DOMContentLoaded', () => {
    const scrollThreshold = document.documentElement.scrollHeight - window.innerHeight;

    let isElementRemoved = true;

    let navbarDiv = document.querySelector("#home-page-photo-div");
    let titleImg = document.querySelector("#home-page-bg-img");
    let titleName = document.querySelector("#title-name");

    const container = document.createElement('div');
            container.id = 'homepage-temp-div';
            container.className = 'absolute top-[30vh] inset-x-0 mx-auto w-[90%] md:w-[55%] bg-[rgba(252,249,241,0.75)] text-black text-base md:text-lg lg:text-xl pt-8 pb-8 px-2 text-center rounded-[30px] shadow-[4px_4px_15px_#000]';
            container.innerHTML = `
                <span class="text-3xl md:text-5xl font-serif">Welcome to Culinary Companion</span></br></br>
                <span class="text-2xl md:text-4xl font-light"><i>Discover NYC spots fitting your lifestyle</i></span></br>
                <span class="text-2xl md:text-4xl font-light"><i>with ease and flavor</i></span>

            `;

            const buttonContainer = document.createElement('div');
            buttonContainer.id = 'scroll-button';
            buttonContainer.innerHTML = `
                <button id="scrollButton" class="whitespace-nowrap absolute top-[77%] right-[5%] md:right-[15%] text-sm md:text-lg bg-[#d0dbb9] border-2 border-[#222] rounded-[30px] shadow-[4px_4px_0_0_#222] text-[#000] cursor-pointer inline-block font-semibold text-[18px] px-[25px] py-[1vh] text-center touch-manipulation transition-colors hover:bg-[#aab491] active:shadow-[2px_2px_0_0_#333] active:translate-x-[2px] active:translate-y-[2px]">Get Started</button>
            `;

    const parentDiv = document.querySelector("#home-page-photo-div"); // Parent container
    parentDiv.appendChild(container);
    parentDiv.appendChild(buttonContainer);
    isElementRemoved = false;

    const scrollButton = document.getElementById('scrollButton');

    // Add click event listener to the button
    scrollButton.addEventListener('click', () => {
        // Calculate the scroll position for 82% vertically
        const totalHeight = document.documentElement.scrollHeight - window.innerHeight;
        const targetScrollPosition = totalHeight;

        // Scroll to the target position smoothly
        window.scrollTo({
            top: targetScrollPosition,
            behavior: 'smooth'
        });
    });


    window.addEventListener('scroll', () => {
        const scrollPosition = window.scrollY;
        const opacity = (1 - (scrollPosition/scrollThreshold));
        const height = window.innerHeight - scrollPosition;
        const margin = scrollPosition;

        titleImg.style.opacity = opacity;
        // navbarDiv.style.height = `${height}px`;
        // navbarDiv.style.marginTop = `${margin}px`;
        titleName.style.marginTop = `${margin}px`;


        // console.log("Height:", opacity);


        if (scrollPosition > scrollThreshold*0.1 && !isElementRemoved) {
            let elementToRemove = document.getElementById("homepage-temp-div");
            elementToRemove.remove();
            elementToRemove = document.getElementById("scroll-button");
            elementToRemove.remove();
            isElementRemoved = true; // Mark the element as removed
        } else if (scrollPosition < scrollThreshold*0.1 && isElementRemoved) {
            // Add the element back
            parentDiv.appendChild(container);
            parentDiv.appendChild(buttonContainer);
            isElementRemoved = false; // Reset the removed state

        }
    });
    

});