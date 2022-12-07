<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://zohaibahmad.com
 * @since      1.0.0
 *
 * @package    Za_Plugin
 * @subpackage Za_Plugin/public/partials
 */
?>

<div class="za-form-wrapper">
    <div class="za-container">
        <div class="za-title">Your Website Data</div>
        <form action="#" id="website_post_form">
            <div class="za-user__details">
                <div class="za-input__box">
                    <span class="za-details">Full Name</span>
                    <input type="text" placeholder="E.g: John Smith" required id="za_username">
                </div>
                <div class="za-input__box">
                    <span class="za-details">Website Url</span>
                    <input type="text" placeholder="https://www.example.com" required id="za_website_url">
                </div>
            </div>
            <div class="za-button">
                <input type="submit" value="Register">
                <img src="https://i.gifer.com/origin/34/34338d26023e5515f6cc8969aa027bca_w200.gif" width="20px" class="za-preloader">
            </div>
        </form>
    </div>
</div>