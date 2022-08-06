<?php
function __blog_comment(){
    extract($GLOBALS['blog']);
    ?>
<div class="comments-area" id="comments">

<h2 class="comments-title"><?= count($__comments) ?> Comments</h2>

<ol class="comment-list">
    
    <?php if(isset($__comments) && count($__comments) > 0):  ?>
        <?php foreach ($__comments as $__comments): ?>
            
            <li id="comment-396" class="comment even thread-even depth-1">
                <div class="media">
                    <div class="gravatar-wrapper media-left">
                        <img class="avatar avatar-100 photo" src="<?= $__comments->image ?? '/Public/assets/images/blog/avatar.jpg' ?>" alt="">
                    </div>

                    <div class="comment-body media-body">

                        <div class="comment-content" id="div-comment-396">
                            <p>
                                <?= html_entity_decode($__comments->comment) ?? '' ?>
                            </p>
                        </div>

                        <div class="comment-meta" id="div-comment-meta-396">
                            <div class="author vcard">
                                <cite class="fn media-heading"><?= $__comments
                                ->f_name ?? ''.' '.$__comments->l_name ?? $__comments->name ?? '' ?></cite>
                            </div>

                            <div class="date">
                                <a class="comment-date" href="#"><?= $__comments->date ?? '' ?></a>
                            </div>

                            <div class="reply">
                                <a aria-label="Reply to <?= $__comments
                                ->f_name ?? ''.' '.$__comments->l_name ?? '' ?>" href="#" class="comment-reply-link" rel="nofollow">Reply</a>
                            </div>
                        </div>

                    </div><!-- /.comment-body -->
                </div><!-- /.media -->
            </li>
        <?php endforeach; ?>
    <?php else: ?>
    <?php endif; ?>
</ol><!-- .comment-list -->

<?php if($__post_details !== false): ?>
    <div class="comment-respond" id="respond">
        <h3 class="comment-reply-title" id="reply-title">Leave a Reply <small><a style="display:none;" href="#" id="cancel-comment-reply-link" rel="nofollow">Cancel reply</a></small></h3>
        <form class="comment-form" id="commentform" method="post" action="#">
            <p class="comment-notes"><span id="email-notes">Your email address will not be published.</span> Required fields are marked <span class="required">*</span></p><p class="comment-form-comment"><label for="comment">Comment</label> <textarea required="required" maxlength="65525" rows="8" cols="45" name="comment" id="comment"></textarea></p><p class="comment-form-author"><label for="author">Name <span class="required">*</span></label> <input type="text" required="required" ari-required="true" maxlength="245" size="30" value="" name="author" id="author"></p>
            <p class="comment-form-email"><label for="email">Email <span class="required">*</span></label> <input type="email" required="required" aria-required="true" aria-describedby="email-notes" maxlength="100" size="30" value="" name="email" id="email"></p>
            <p class="comment-form-url"><label for="url">Website</label> <input type="url" maxlength="200" size="30" value="" name="url" id="url"></p>
            <p class="form-submit"><input  type="submit" value="Post Comment" class="submit comment-submit"></p>
        </form>
    </div><!-- #respond -->
<?php endif; ?>

</div>

    <?php
}