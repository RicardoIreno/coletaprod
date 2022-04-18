
<div class="core"> 

<div class="core-one">

  <div class="co-photo-wrapper">
    <img class="co-bestBagde" src="../inc/images/badges/bolsista-cnpq-1a.svg"/>  
    <div class="co-photo-container">
      <img class="co-photo" src="../inc/images/profile/bertola.jpg" />
    </div>
  </div>
  
  <img 
    class="country-flag" 
    src="../inc/images/country_flags/br.svg" 
    alt="nacionalidade brasileira"
    title="nacionalidade brasileira" />
  
  <div class="co-badgeIcons">    
      <img 
        class="co-badgeIcons-icon" 
        {% case badge.type %}
          {% when "orientador" %} 
          src="../inc/images/badges/advisor.svg"  
          alt="Professor orientador"
          title="Professor orientador"
      />
  </div>
</div>

<div class="core-two">
  <h1 class="ty-name"><?php echo $profile["nome_completo"] ?></h1>
  <!-- <div class="u-spacer-2  "></div> -->
  <h2 class="ty ty-prof">Instituição</h2>
  <p class="ty ty-prof">Escola instituto</p>
  <p class="ty ty-prof">Orgão</p>
  <p class="ty ty-email">email@email.com</p>
  <div class="u-spacer-1"></div>
  

  <h3 class="ty-subtitle">Perfis na web</h3>
  <div class="co-socialIcons">

    <!-- {% for social in page.socials %}
      <img 
        href="{{social.url}}" 
        class="co-socialIcons-icon" 
        src="../inc/images/academic_plataforms/logo_{{social.name}}.svg"  
        alt="{{social.alt}}" 
        title="{{social.alt}}" 
      />
    {% endfor %} -->

    <span class="u-vseparator">|</span>
    
    <!-- {% for social in page.socials2 %}
      <img 
        href="{{social.url}}" 
        class="co-socialIcons-icon" 
        src="../inc/images/social/{{social.name}}.svg"  
        alt="{{social.alt}}" 
        title="{{social.alt}}" 
      />
    {% endfor %} -->
  </div>

</div>  

<div class="core-three">

  <div class="co-numbers">
    <span class="co-numbers-number">
      <img class="co-numbers-icon"src="../inc/images/icons/article-published.svg" alt="Artigos publicados" />
      45
    </span>

    <span class="co-numbers-number">
      <img class="co-numbers-icon"src="../inc/images/icons/article-aproved.svg" alt="Artigos aprovados"/>
      35
    </span>

    <span class="co-numbers-number">
      <img class="co-numbers-icon"src="../inc/images/icons/orientation.svg" alt="Orientações"/>
      12
    </span>

    <span class="co-numbers-number">
      <img class="co-numbers-icon"src="../inc/images/icons/research.svg" alt="Pesquisas"/>
      15
    </span>

    <span class="co-numbers-number">
      <img class="co-numbers-icon"src="../inc/images/icons/event.svg" alt="Eventos participados"/>
      41
    </span>

  </div>

  <div class="graph">
    <a class="u-skip" href=”#skipgraph”>Pular gráfico</a>

    <!-- <div class="graph-line"> 
      <span class="graph-label">Artigos publicados</span>
      {% for year in page.artigos_publicados%}
        <div class="graph-unit" data-weight="{{ year.qtd }}"></div>
      {% endfor %}
    </div>
    <div class="graph-line"> 
      <span class="graph-label">Artigos publicados</span>
      {% for year in page.artigos_publicados%}
        <div class="graph-unit" data-weight="{{ year.qtd }}"></div>
      {% endfor %}
    </div>
    
    <div class="graph-line"> 
      <span class="graph-label">Livros e capítulos</span>
      {% for year in page.livros_e_capitulos%}
        <div class="graph-unit" data-weight="{{ year.qtd }}"></div>
      {% endfor %}
    </div>  
    
    <div class="graph-line graph-division"> 
      <span class="graph-label">Orientações de mestrado</span>
      {% for year in page.orientacoes_mestrado%}
        <div class="graph-unit" data-weight="{{ year.qtd }}"></div>
      {% endfor %}
    </div>
    
    <div class="graph-line"> 
      <span class="graph-label">Orientações de doutorado</span>
      {% for year in page.orientacoes_doutorado %}
        <div class="graph-unit" data-weight="{{ year.qtd }}"></div>
      {% endfor %}
    </div>
    
    <div class="graph-line"> 
      <span class="graph-label">Outras orientações</span>
      {% for year in page.outras_orirentacoes%}
        <div class="graph-unit" data-weight="{{ year.qtd }}"></div>
      {% endfor %}
    </div>

    <div class="graph-line"> 
      <span class="graph-label">Ensino</span>
      {% for year in page.ensino%}
        <div class="graph-unit" data-weight="{{ year.qtd }}"></div>
      {% endfor %}
    </div>

    <div class="graph-line graph-division"> 
      <span class="graph-label">Sofwtwares e patentes</span>
      {% for year in page.softwares_patentes %}
        <div class="graph-unit" data-weight="{{ year.qtd }}"></div>
      {% endfor %}
    </div>
    
    <div class="graph-line"> 
      <span class="graph-label">Trabalhos em eventos</span>
      {% for year in page.trabalhos_em_eventos%}
        <div class="graph-unit" data-weight="{{ year.qtd }}"></div>
      {% endfor %}
    </div>
      
    <div class="graph-line"> 
      <span class="graph-label">Participações em eventos</span>
      {% for year in page.participacoes_eventos%}
        <div class="graph-unit" data-weight="{{ year.qtd }}"></div>
      {% endfor %}
    </div>

    <div class="graph-line"> 
      <div class="graph-icon"></div>
        <div class="graph-label">2021 ————— 2015</div>
    </div>   -->

  </div> <!-- // graph -->

  <div class="graph-info">
    <span class="graph-info-label">+</span>
    <div class="graph-unit" data-weight="4"></div>
    <div class="graph-unit" data-weight="3"></div>
    <div class="graph-unit" data-weight="2"></div>
    <div class="graph-unit" data-weight="1"></div>
    <div class="graph-unit" data-weight="0"></div>
    <span class="graph-info-label">-</span>
  </div>
</div>


</div>

<span class="u-skip" id="skipgraph”" class="ty ty-lastUpdate">Atualizado em 20.02.2022</span>