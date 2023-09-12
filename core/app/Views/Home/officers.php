<div id="officers">
        <div class="container py-4">
            <?php 
                if(!(empty($data['site_officers']))) {
                    echo '
                    <div class="section-title-left" data-aos="fade-up">
                        <div class="section-main">
                            <h1>LITES Officers</h1>
                            <p>Heads up to league of information technology newly elected officers.</p>
                        </div>
                    </div>
                    <hr>
                    ';
                } else {
                    echo '
                    <div class="col-12">
                        <div class="bulletin-info">
                            <div class="bulletin-title">
                                No Officers Found
                            </div>
                            <div class="bulletin-date">
                                As of Now  • '.date('F d, Y').'
                            </div>
                            <hr>
                            <div class="bulletin-content">
                                Why Am I seeing this?
                                <ul class="mt-3">
                                    <li>The page you&apos;re trying to access is invalid</li>
                                    <li>The page you&apos;re trying to access doesn&apos;t exist</li>
                                    <li>The page you&apos;re trying to access is temporarily unavailable</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    ';
                }
            ?>
        </div>
    </div>