
<div class="profile-ext-desc"> 

  <div class="p-description">
    <h3 class="ty-subtitle">Resumo</h3>
    <p class="ty">
      <?php echo $profile["texto_resumo_cv_rh"] ?>

      <!-- Possui graduação em Medicina Veterinária pela Universidade de São Paulo (2001), doutorado em Medicina (Urologia) pela Universidade Federal de São Paulo (2006) e Livre-docência em Reprodução Humana pela Universidade Federal de São Paulo. Atualmente, é Pró-reitor Adjunto de Pós-graduação e Pesquisa da Unifesp. Tem experiência na área de Medicina,  -->
    </p>
  </div>
  <div class="u-spacer-2"></div>

  <div class="p-tags">
    <h3 class="ty-subtitle">Tags mais usadas</h3>

    <ul class="tag-cloud" role="navigation" aria-label="Webdev tag cloud">
      <!-- {% for tag in page.tags %}
        <li><a class="tag" data-weight="{{tag.weight}}" href="">{{tag.name}}</a></li>
      {% endfor%} -->
    </ul>
  </div>
  <div class="u-spacer-2"></div>


  <div class="p-language">
    <h3 class="ty-subtitle">Idiomas</h3>
    <p><span>Inglês:</span>Compreende Bem, Fala Bem, Lê Bem, Escreve Bem</p>
    <p><span>Francês:</span>Compreende Bem, Fala Bem, Lê Bem, Escreve Bem</p>

  </div>
  <div class="u-spacer-2"></div>


  <div class="edu">
    <h3 class="ty-subtitle">Formação</h3>

    <!-- {% for formation in page.education %} -->

      <div class="formation-container">
        <div class="u-grid">
          <div class="u-grid-left">
            <img class="pi-icon" src="assets/img/icons/academic.svg" />
          </div>
          
          <div class="u-grid-right">
            <div class="formation">
              <p class="ty-item">formation.title 
                <span class="ty formation-date"> 1990 — 1995 </span>
              </p>
              <p class="ty"> formation.institute </p>
              <div class="u-spacer-1"></div>
              <p class="ty">Grande área: </p>
              <p class="ty">Setor: </p>
            </div>
          </div>
        </div>
      </div>
    <!-- {% endfor %} -->


  </div> <!-- edu end -->

</div> <!-- profile-desc end -->