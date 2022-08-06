<?php

use App\Models\Blog;

function __shop_review_panel($product = '', $review = [])
{
?>
    <style>
        .star-rank {
            display: none;
        }

        .ranked.clicked {
            font-size: larger
        }

        P.stars label {
            width: none !important;
            display: unset !important;
            cursor: pointer;
            transition: 0.5s;
        }

        .star-rank-cont {
            color: transparent;
            -webkit-text-stroke: 1px #ddd;
        }

        .star-rank-cont.ranked {
            color: #fed700 !important;
            -webkit-text-stroke: unset !important;
        }
    </style>

    <div id="reviews" class="electro-advanced-reviews">

        <?php if(!empty($review)): ?>
            <div class="advanced-review row">
                <div class="col-xs-12 col-md-6">
                    <h2 class="based-title">Based on <?= count($review['comment']) ?? 0 ?> reviews</h2>
                    <div class="avg-rating">
                        <span class="avg-rating-number"><?= $review['rating'] ?? 0 ?></span> overall
                    </div>
    
                    <div class="rating-histogram">
                        <div class="rating-bar">
                            <div class="star-rating" title="Rated 5 out of 5">
                                <span style="width:100%"></span>
                            </div>
                            <div class="rating-percentage-bar">
                                <span style="width:<?= $review['count']['five'] ?>%" class="rating-percentage">
    
                                </span>
                            </div>
                            <div class="rating-count zero"><?= $review['count']['five'] ?>%</div>
                        </div><!-- .rating-bar -->
    
                        <div class="rating-bar">
                            <div class="star-rating" title="Rated 4 out of 5">
                                <span style="width:80%"></span>
                            </div>
                            <div class="rating-percentage-bar">
                                <span style="width:<?= $review['count']['four'] ?>%" class="rating-percentage"></span>
                            </div>
                            <div class="rating-count zero"><?= $review['count']['four'] ?>%</div>
                        </div><!-- .rating-bar -->
    
                        <div class="rating-bar">
                            <div class="star-rating" title="Rated 3 out of 5">
                                <span style="width:60%"></span>
                            </div>
                            <div class="rating-percentage-bar">
                                <span style="width:<?= $review['count']['three'] ?>%" class="rating-percentage"></span>
                            </div>
                            <div class="rating-count zero"><?= $review['count']['three'] ?>%</div>
                        </div><!-- .rating-bar -->
    
                        <div class="rating-bar">
                            <div class="star-rating" title="Rated 2 out of 5">
                                <span style="width:40%"></span>
                            </div>
                            <div class="rating-percentage-bar">
                                <span style="width:<?= $review['count']['two'] ?>%" class="rating-percentage"></span>
                            </div>
                            <div class="rating-count zero"><?= $review['count']['two'] ?>%</div>
                        </div><!-- .rating-bar -->
    
                        <div class="rating-bar">
                            <div class="star-rating" title="Rated 1 out of 5">
                                <span style="width:20%"></span>
                            </div>
                            <div class="rating-percentage-bar">
                                <span style="width:<?= $review['count']['one'] ?>%" class="rating-percentage"></span>
                            </div>
                            <div class="rating-count zero"><?= $review['count']['one'] ?>%</div>
                        </div><!-- .rating-bar -->
                    </div>
                </div><!-- /.col -->
    
                <div class="col-xs-12 col-md-6">
                    <div id="review_form_wrapper">
                        <div id="review_form">
                            <div id="respond" class="comment-respond">
                                <h3 id="reply-title" class="comment-reply-title">Add a review
                                    <small><a rel="nofollow" id="cancel-comment-reply-link" href="#" style="display:none;">Cancel reply</a>
                                    </small>
                                </h3>
    
                                <form action="#" method="post" id="_rating_form" class="comment-form">
                                    <p class="comment-form-rating">
                                        <label>Your Rating</label>
                                    </p>
    
                                    <p class="stars">
                                        <label for="star-1" class="star-rank-cont">
                                            <i class="fa fa-star"></i>
                                            <input class="star-rank" value="1" type="checkbox" name="star" id="star-1">
                                        </label>
                                        <label for="star-2" class="star-rank-cont">
                                            <i class="fa fa-star"></i>
                                            <input class="star-rank" value="2" type="checkbox" name="star" id="star-2">
                                        </label>
                                        <label for="star-3" class="star-rank-cont">
                                            <i class="fa fa-star"></i>
                                            <input class="star-rank" value="3" type="checkbox" name="star" id="star-3">
                                        </label>
                                        <label for="star-4" class="star-rank-cont">
                                            <i class="fa fa-star"></i>
                                            <input class="star-rank" value="4" type="checkbox" name="star" id="star-4">
                                        </label>
                                        <label for="star-5" class="star-rank-cont">
                                            <i class="fa fa-star"></i>
                                            <input class="star-rank" value="5" type="checkbox" name="star" id="star-5">
                                        </label>
                                    </p>
    
                                    <p class="comment-form-comment">
                                        <label for="comment">Your Review</label>
                                        <textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required></textarea>
                                    </p>
                                    <p class="text-danger comment-alert" style="display:none"></p>
    
                                    <p class="form-submit">
                                        <input name="submit" type="submit" id="submit" class="submit" value="Add Review" />
                                        <input type='hidden' name='product_rating' value='<?= Blog::enc($product ?? '') ?>' id='product_rating' />
                                    </p>
    
                                    <!-- <input type="hidden" id="_wp_unfiltered_html_comment_disabled" name="_wp_unfiltered_html_comment_disabled" value="c7106f1f46" />
                                <script>(function(){if(window===window.parent){document.getElementById('_wp_unfiltered_html_comment_disabled').name='_wp_unfiltered_html_comment';}})();</script> -->
                                </form><!-- form -->
                            </div><!-- #respond -->
                        </div>
                    </div>
    
                </div><!-- /.col -->
            </div><!-- /.row -->
        <?php endif; ?>

        <div id="comments">
            <ol class="commentlist">
                <?php if (isset($review['comment']) && count($review['comment']) > 0) : ?>
                    <?php foreach ($review['comment'] as $comment) : ?>
                        <li itemprop="review" class="comment even thread-even depth-1">

                            <div id="comment-390" class="comment_container">

                                <img alt='' src="/Public/assets/images/blog/avatar.jpg" class='avatar' height='60' width='60' />
                                <div class="comment-text">

                                    <div class="star-rating" title="Rated 4 out of 5">
                                        <span style="width:<?= $comment->rate * 20 ?>%"><strong itemprop="ratingValue"><?= $comment->rate ?></strong> out of 5</span>
                                    </div>


                                    <p class="meta">
                                        <strong><?= $comment->lname . ' ' . $comment->fname ?></strong> &ndash;
                                        <time itemprop="datePublished" datetime="2016-03-03T14:13:48+00:00"><?= $comment->date ?? '__' ?></time>:
                                    </p>



                                    <div itemprop="description" class="description">
                                        <p>
                                            <?= htmlentities(html_entity_decode($comment->message ?? '__')) ?>
                                        </p>
                                    </div>


                                    <p class="meta">
                                        <strong itemprop="author"><?= $comment->lname . ' ' . $comment->fname ?></strong> &ndash; <time itemprop="datePublished" datetime="2016-03-03T14:13:48+00:00"><?= $comment->date ?? '__' ?></time>
                                    </p>


                                </div>
                            </div>
                        </li><!-- #comment-## -->
                    <?php endforeach; ?>
                <?php else : ?>
                    <li itemprop="review" class="comment even thread-even depth-1">

                        <div id="comment-390" class="comment_container">

                            <img alt='' src="/Public/assets/images/blog/avatar.jpg" class='avatar' height='60' width='60' />
                            <div class="comment-text">

                                <div class="star-rating" title="Rated 4 out of 5">
                                    <span style="width:0%"><strong itemprop="ratingValue">0</strong> out of 5</span>
                                </div>

                                <div itemprop="description" class="description">
                                    <p>
                                        Be the first to comment
                                    </p>
                                </div>

                            </div>
                        </div>
                    </li><!-- #comment-## -->
                <?php endif; ?>
            </ol><!-- /.commentlist -->

        </div><!-- /#comments -->

        <div class="clear"></div>
    </div><!-- /.electro-advanced-reviews -->
    <script>
        let stars = document.querySelectorAll('.star-rank-cont')
        stars.forEach((star, d) => {
            star.onmouseover = (e) => {
                for (let i = 1; i <= stars.length; i++) {
                    let st = document.getElementById('star-' + i)
                    st.parentElement.classList.remove('ranked')
                    st.checked = false
                }

                for (let i = 1; i <= d + 1; i++) {
                    document.getElementById('star-' + i)
                        .parentElement.classList.add('ranked')
                }
            }

            star.onmouseleave = (e) => {
                for (let i = 1; i <= stars.length; i++) {
                    let leave = document.getElementById('star-' + i)
                    leave.parentElement.classList.remove('ranked')
                }

                let id = d + 1
                let current = document.getElementById('star-' + id)
                console.log(current.checked)
                if (current.checked) {
                    for (let i = 0; i <= d; i++) {
                        stars[i].classList.add('ranked')
                    }
                }
            }

            star.onclick = (e) => {
                for (let i = 1; i <= stars.length; i++) {
                    document.getElementById('star-' + i).checked = false
                }
                for (let i = 1; i <= d + 1; i++) {
                    let clk = document.getElementById('star-' + i)
                    clk.checked = true
                    clk.parentElement.classList.add('ranked')
                }
            }
        })
    </script>
<?php
}
