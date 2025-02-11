function showMenu() {
    const menu = {
        hotLattes: [
            { name: "Caramel Latte", price: " $4.50" },
            { name: "Chai Latte", price: "$4.50" },
            { name: "Cinnamon Latte", price: "$4.50" },
            { name: "Hazelnut Latte", price: " $4.50" },
            { name: "Lavender Latte", price: " $4.50" },
            { name: "Matcha Latte", price: " $4.50" },
            { name: "Pistachio Latte", price: " $4.50" },
            { name: "Pumpkin Spice Latte", price: " $4.50" },
            { name: "Vanilla Latte", price: " $4.50" }



        ],
        icedLattes: [
            { name: "Iced Caramel Latte", price: "$5.00" },
            { name: "Iced Chai Latte", price: "$5.00" },
            { name: "Iced Hazelnut Latte", price: "$5.00" },
            { name: "Iced Honey Lavender Latte", price: " $5.00" },
            { name: "Iced Matcha Latte", price: " $5.00" },
            { name: "Iced Pistachio Latte", price: " $5.00" },
            { name: "Iced Pumpkin Spice Latte", price: " $5.00" },
            { name: "Iced Vanilla Latte", price: "$5.00"}

        ],
        hotEspresso: [
            { name: "Americano", price: "$3.00" },
            { name: "Affogato", price: "$3.00" },
            { name: "Cappuccino", price: "$3.50" },
            { name: "Cortado", price: "$3.50" },
            { name: "Espresso", price: "$2.50" },
        ],
        icedEspresso: [
            { name: "Iced Americano", price: "$3.30" },
            { name: "Iced Cappuccino", price: "$3.80" },
            { name: "Iced Cortado", price: "$3.80" },
            { name: "Iced Espresso", price: "$2.80" },
            { name: "Iced Nitro Cold Brew", price: "$4.00" },

        ]
    };
    const selectedType = document.getElementById("drinkType").value;
    const menuContainer = document.getElementById("menu");

    menuContainer.innerHTML = ""; // Clear previous menu

    if (selectedType) {
        const drinks = menu[selectedType];
        const sectionTitle = selectedType.replace(/([A-Z])/g, ' $1').toUpperCase(); // Capitalize words
        menuContainer.innerHTML = `<h3>${sectionTitle}</h3>`;
        
        drinks.forEach(drink => {
            const drinkElement = document.createElement("div");
            drinkElement.classList.add("menu-item");
            drinkElement.innerHTML = `${drink.name} - <span>${drink.price}</span>`;
            menuContainer.appendChild(drinkElement);
        });
    }
}
