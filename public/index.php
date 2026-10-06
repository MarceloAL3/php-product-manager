<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        PHP Product Manager
    </title>

    <link
        rel="stylesheet"
        href="/css/style.css"
    >

</head>

<body>

    <main class="container">

        <header>

            <p class="eyebrow">
                PHP + PostgreSQL + JWT
            </p>

            <h1>
                🛒 Product Manager
            </h1>

            <p>
                Gerenciamento de produtos
                com API REST.
            </p>

        </header>


        <section class="card">

            <h2>
                Login
            </h2>

            <form id="loginForm">

                <input
                    id="email"
                    type="email"
                    placeholder="E-mail"
                    required
                >

                <input
                    id="password"
                    type="password"
                    placeholder="Senha"
                    required
                >

                <button type="submit">
                    Entrar
                </button>

            </form>

            <p id="loginMessage"></p>

            <hr>

<h3>Criar conta</h3>

<form id="registerForm">

    <input
        id="registerName"
        type="text"
        placeholder="Nome"
        required
    >

    <input
        id="registerEmail"
        type="email"
        placeholder="E-mail"
        required
    >

    <input
        id="registerPassword"
        type="password"
        placeholder="Senha"
        required
    >

    <button type="submit">
        Criar conta
    </button>

</form>

<p id="registerMessage"></p>

        </section>


        <section class="card">

            <div class="section-header">

                <div>

                    <h2>
                        Produtos
                    </h2>

                    <p>
                        Lista pública de produtos.
                    </p>

                </div>

                <button id="loadProducts">
                    Atualizar
                </button>

            </div>

            <div id="products"></div>

        </section>


        <section
            class="card"
            id="productFormSection"
        >

            <h2>
                Novo produto
            </h2>

            <form id="productForm">

                <input
                    id="productName"
                    placeholder="Nome do produto"
                    required
                >

                <input
                    id="productDescription"
                    placeholder="Descrição"
                >

                <input
                    id="productPrice"
                    type="number"
                    step="0.01"
                    min="0"
                    placeholder="Preço"
                    required
                >

                <input
                    id="productStock"
                    type="number"
                    min="0"
                    placeholder="Estoque"
                    required
                >

                <button type="submit">
                    Cadastrar produto
                </button>

            </form>

            <p id="productMessage"></p>

        </section>

    </main>


    <script src="/js/app.js"></script>

</body>

</html>