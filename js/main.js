let cards = document.querySelectorAll(".card");

cards.forEach((card) => {
  card.addEventListener("mouseover", () => {
    let curentCard = event.currentTarget;
    let description = curentCard.querySelector(".description");

    if (description) {
      description.classList.remove("d-none");
    }
  });

  card.addEventListener("mouseout", () => {
    let curentCard = event.currentTarget;
    let description = curentCard.querySelector(".description");

    if (description) {
      description.classList.add("d-none");
    }
  });
});
