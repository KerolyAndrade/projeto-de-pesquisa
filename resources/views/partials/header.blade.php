<header>

    <div class="header-container">
        <div class="logo">Congregações Católicas, Educação e Estado Nacional</div>
        <div class="menu-toggle" onclick="toggleMenu()">&#9776;</div>
        <nav class="nav">
            <ul class="nav-links">
                <li><a href="{{ route('congregations.index') }}">Início</a></li>
                <li><a href="#">Manual</a></li>
                <li><a href="#">Sobre</a></li>
                <li><a href="{{ route('congregations.mapa') }}">Gráficos</a></li>
                <li><a href="#">Repositório</a></li>
                <li><a href="#">Equipe</a></li>
            </ul>
        </nav>
    </div>
</header>

<script>
   
const menuToggle = document.querySelector('.menu-toggle');
const nav = document.querySelector('.nav');

menuToggle.addEventListener('click', function() {
    nav.classList.toggle('active');
});

// Fechar o menu ao clicar em um link (opcional)
const navLinks = document.querySelectorAll('.nav-links a');

navLinks.forEach(function(link) {
    link.addEventListener('click', function() {
        nav.classList.remove('active');
    });
});

</script>

