<footer class="myfooter">

    <div class="myfooter__wrapper">

        <div class="myfooter__contact">
            <a class="myfooter__link" href="https://atendimento.unifesp.br/">
                Fale conosco</a> <span class="myfooter__link-det">|</span>
            <a class="myfooter__link" href="https://atendimento.unifesp.br/">
                Política de privacidade</a> <span class="myfooter__link-det">|</span>
            <a class="myfooter__link" target="_blank" href="https://forms.gle/2QRcqg2YfxMvEqVX9">
                Relate erros</a>

        </div>

        <div class="myfooter__logos">
            <?php if (file_exists("inc/images/logos/sti-branco.svg")) : ?>
                <a href="https://sti.unifesp.br/" target="_blank"><img class="myfooter__logo" src="inc/images/logos/sti-branco.svg" alt="STI"></a>
            <?php endif ?>
            <?php if (file_exists("../inc/images/logos/sti-branco.svg")) : ?>
                <a href="https://sti.unifesp.br/" target="_blank"><img class="myfooter__logo" src="../inc/images/logos/sti-branco.svg" alt="STI"></a>
            <?php endif ?>
            <?php if (file_exists("inc/images/logos/unifesp-branco.svg")) : ?>
                <a href="https://unifesp.br/" target="_blank"><img class="myfooter__logo" src="inc/images/logos/unifesp-branco.svg" alt="Unifesp"></a>
            <?php endif ?>
            <?php if (file_exists("../inc/images/logos/unifesp-branco.svg")) : ?>
                <a href="https://unifesp.br/" target="_blank"><img class="myfooter__logo" src="../inc/images/logos/unifesp-branco.svg" alt="Unifesp"></a>
            <?php endif ?>

        </div>

        <div class="citation__container">
            <p class=citation>
                <b>Como citar:</b> <br />
                <span class="citation__author"> Unifesp. </span>
                <span class="citation__italic">ln:</span>
                Prod+.
                1.0.
                São Paulo: Unifesp, 2021
                Disponível em: https://unifesp.br/prodmais/
                Acessado em: XX jan. 20XX.
            </p>
        </div>



    </div>



</footer>