const state = {
    token: localStorage.getItem("token"),
};

const loginForm =
    document.querySelector("#loginForm");

const productForm =
    document.querySelector("#productForm");

const productsContainer =
    document.querySelector("#products");

const loginMessage =
    document.querySelector("#loginMessage");

const productMessage =
    document.querySelector("#productMessage");


loginForm.addEventListener(
    "submit",
    async (event) => {

        event.preventDefault();

        const response =
            await fetch(
                "/api/auth/login.php",
                {
                    method: "POST",

                    headers: {
                        "Content-Type":
                            "application/json",
                    },

                    body: JSON.stringify({
                        email:
                            document.querySelector(
                                "#email"
                            ).value,

                        password:
                            document.querySelector(
                                "#password"
                            ).value,
                    }),
                }
            );

        const data =
            await response.json();

        if (!response.ok) {

            loginMessage.textContent =
                data.message;

            return;
        }

        state.token =
            data.token;

        localStorage.setItem(
            "token",
            data.token
        );

        loginMessage.textContent =
            `Olá, ${data.user.name}! Login realizado.`;
    }
);


productForm.addEventListener(
    "submit",
    async (event) => {

        event.preventDefault();

        if (!state.token) {

            productMessage.textContent =
                "Faça login antes de cadastrar um produto.";

            return;
        }

        const response =
            await fetch(
                "/api/products/create.php",
                {
                    method: "POST",

                    headers: {
                        "Content-Type":
                            "application/json",

                        "Authorization":
                            `Bearer ${state.token}`,
                    },

                    body: JSON.stringify({

                        name:
                            document.querySelector(
                                "#productName"
                            ).value,

                        description:
                            document.querySelector(
                                "#productDescription"
                            ).value,

                        price:
                            Number(
                                document.querySelector(
                                    "#productPrice"
                                ).value
                            ),

                        stock:
                            Number(
                                document.querySelector(
                                    "#productStock"
                                ).value
                            ),
                    }),
                }
            );

        const data =
            await response.json();

        productMessage.textContent =
            data.message;

        if (response.ok) {

            productForm.reset();

            loadProducts();
        }
    }
);


document
    .querySelector("#loadProducts")
    .addEventListener(
        "click",
        loadProducts
    );


async function loadProducts() {

    const response =
        await fetch(
            "/api/products/list.php"
        );

    const data =
        await response.json();

    productsContainer.innerHTML = "";

    if (!data.products.length) {

        productsContainer.textContent =
            "Nenhum produto cadastrado.";

        return;
    }

    data.products.forEach(
        (product) => {

            const item =
                document.createElement(
                    "div"
                );

            item.className =
                "product";

            item.innerHTML = `
                <strong>
                    ${escapeHtml(product.name)}
                </strong>

                <span>
                    ${escapeHtml(
                        product.description ?? ""
                    )}
                </span>

                <p>
                    R$ ${Number(
                        product.price
                    ).toFixed(2)}

                    · Estoque:
                    ${product.stock}
                </p>
            `;

            productsContainer.appendChild(
                item
            );
        }
    );
}


function escapeHtml(value) {

    return String(value)

        .replaceAll(
            "&",
            "&amp;"
        )

        .replaceAll(
            "<",
            "&lt;"
        )

        .replaceAll(
            ">",
            "&gt;"
        )

        .replaceAll(
            '"',
            "&quot;"
        )

        .replaceAll(
            "'",
            "&#039;"
        );
}


loadProducts();

const registerForm =
    document.querySelector("#registerForm");

const registerMessage =
    document.querySelector("#registerMessage");

registerForm.addEventListener(
    "submit",
    async (event) => {

        event.preventDefault();

        const response =
            await fetch(
                "/api/auth/register.php",
                {
                    method: "POST",

                    headers: {
                        "Content-Type":
                            "application/json"
                    },

                    body: JSON.stringify({

                        name:
                            document.querySelector(
                                "#registerName"
                            ).value,

                        email:
                            document.querySelector(
                                "#registerEmail"
                            ).value,

                        password:
                            document.querySelector(
                                "#registerPassword"
                            ).value
                    })
                }
            );

        const data =
            await response.json();

        registerMessage.textContent =
            data.message;

        if (response.ok) {

            registerForm.reset();
        }
    }
);