<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$email    = (string) get_theme_mod( 'ac_contact_email', 'asiancaucasian@gmail.com' );
$location = (string) get_theme_mod( 'ac_contact_location', 'Indianapolis, Indiana' );
?>
<section id="contact">
	<div class="container">
		<div class="contact-inner">
			<div class="contact-info">
				<p class="section-label reveal">// Contact</p>
				<h2 class="section-title reveal delay-1"><?php echo wp_kses_post( get_theme_mod( 'ac_contact_title_html', 'Say Hello<br>(We Dare You)' ) ); ?></h2>
				<p class="reveal delay-2"><?php echo wp_kses_post( get_theme_mod( 'ac_contact_intro', '' ) ); ?></p>
				<div class="contact-links reveal delay-3">
					<?php if ( $email ) : ?>
						<a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>" class="contact-link-item">
							<span class="contact-link-icon">✉</span>
							<div class="contact-link-text">
								<div class="contact-link-label">Email</div>
								<div class="contact-link-value"><?php echo esc_html( antispambot( $email ) ); ?></div>
							</div>
						</a>
					<?php endif; ?>
					<?php if ( $location ) : ?>
						<span class="contact-link-item" style="cursor:default;">
							<span class="contact-link-icon">📍</span>
							<div class="contact-link-text">
								<div class="contact-link-label">Location</div>
								<div class="contact-link-value"><?php echo esc_html( $location ); ?></div>
							</div>
						</span>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
