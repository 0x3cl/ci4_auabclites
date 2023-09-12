    <div id="footer">
        <div class="footer-inner">
            <div class="container py-5">
                <div class="footer-logo" data-aos="fade-up">
                    <img src="<?= base_url('/assets/home/images/logo/'. $data['site_images'][2]->image . '') ?>" alt="logo">
                </div>
                <div class="row mt-5">
                    <div class="col-12 col-md-5 mb-3" data-aos="fade-up">
                        <h5>ARELLANO UNIVERSITY</h5>
                        <h6><?= $data['site_contacts'][6]->value ?></h6>
                        <hr>
                        <h5>Keep in Touch</h5>
                        <ul class="list-unstyled">
                            <li class="list-unstyled-item">
                                <?= $data['site_contacts'][4]->value ?>
                            </li>
                            <li class="list-unstyled-item">
                                <?= $data['site_contacts'][3]->value ?>
                            </li>
                        </ul>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="<?= $data['site_contacts'][0]->value ?>" class="text-link">
                                    <i class='bx bxl-facebook'></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="<?= $data['site_contacts'][1]->value ?>" class="text-link">
                                    <i class='bx bxl-instagram' ></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="<?= $data['site_contacts'][2]->value ?>" class="text-link">
                                    <i class='bx bxl-twitter' ></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="<?= $data['site_contacts'][3]->value ?>" class="text-link">
                                    <i class='bx bxs-envelope'></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-7 mb-3" data-aos="fade-up">
                        <div style="width: 100%">
                            <iframe width="100%" height="" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=<?= $data['site_contacts'][6]->value ?>&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-outer">
            <div class="container py-3">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="https://www.arellano.edu.ph/" class="text-link">Arellano University</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="<?= base_url('/about') ?>" class="text-link">About</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="<?= base_url('/sites-privacy-notice') ?>" class="text-link">Data Privacy</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="<?= base_url('/trademark-policy') ?>" class="text-link">Trademark Policy</a>
                    </li>
                </ul>
                <h6 class="text-center mt-5">&copy;2023 | SITE Developers | <a href="https://iamcarlllemos.online" class="text-link" target="_blank">CL</a></h6>
            </div>
        </div>
    </div>
</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/lightgallery.min.js" integrity="sha512-dSI4QnNeaXiNEjX2N8bkb16B7aMu/8SI5/rE6NIa3Hr/HnWUO+EAZpizN2JQJrXuvU7z0HTgpBVk/sfGd0oW+w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/lightgallery.umd.min.js" integrity="sha512-6vFONv+JJD01XArGGqxABRY3Vsm8tKuemThmZYfha9inGIuqPU5OgZP1QizBf0Y3JGPnrofy3jokdebgYNNhEQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/plugins/zoom/lg-zoom.min.js" integrity="sha512-BfC/MaayF9sOZyn1bs1R1P8dEugU7v0j5Qu2FeWVfF/rhKUKZBD9kgNqRNinefIp9zAE7g2KhlwwhMpl5V1jMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/plugins/thumbnail/lg-thumbnail.min.js" integrity="sha512-Jx+orEb1KJtJ6Ajfshhr7is0zqgUC7H9ylk76KMtB9Ea2WAf/Muyzpe9zvBAYQQQKdAbj+rNYEorsRQLsmRafA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="<?= base_url('/assets/home/libraries/js/app.js') ?>"></script>
</html>