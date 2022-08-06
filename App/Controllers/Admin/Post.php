<?php
namespace App\Controllers\Admin;

use App\Auth;
use App\Flash;
use App\Models\Blog;
use Core\View;
use App\Controllers\Admin\Authenticated;
use Core\Controller;

/**
 * Admin Controller
 */

class Post extends Controller
{
    protected function before()
    {
        $this->requireAdmin();
        $this->user = Auth::getAdmin();
    }
    /**
     * Render Post Page
     * create new post
     * @return void
     */
    public function newAction()
    {
        if(isset($_POST['title'])){
            $_POST['author'] = $this->user->user_id;
            if($_POST['title'] == ''){
                Flash::addMessage('You have a blank field', Flash::WARNING);
                Flash::addMessage('Looks like an error occured');
                if(isset($_GET['edit']))
                    $this->redirect('/admin/post/new?edit='.$_GET['edit']);
                $this->redirect('/admin/post/new');
            }
            if(Blog::savePost($_POST)){
               Flash::addMessage('You created a post... ', Flash::SUCCESS);
            }else{
               Flash::addMessage('Something went wrong', Flash::WARNING);
               if(isset($_GET['edit']))
                   $this->redirect('/admin/post/new?edit='.$_GET['edit']);
            }
            $this->redirect('/admin/post/all');

            // header('content-type: application/json');
            // echo json_encode($_POST);
            // return;
        }

       $id = $_GET['edit'] ??  false;

        View::draw('{blog/new}', [
           '__is_admin' => true,
            '__is_edit' => $id
        ]); 
    }

    public function autoAction()
    {
        // $_POST['author'] = $this->user->user_id;
        // $save = Blog::savePost($_POST);
        header('content-type: application/json');
        echo json_encode($_POST);
    }

    /**
     * Save post to DB
     * @return void
     */
    public function savePostAction()
    {
    }
    public function allAction()
    {
        // return;
        $statCount = Blog::postStat();
        
        $stat = [];
        foreach ($statCount['stat'] as $key) {
            $stat['__'.$key->status] = $key->count;
        }
        $stat['__all'] = $statCount['all']->total;
        // echo json_encode($stat);
        // return;
        
        
        if(isset($_GET['post'])){
            $posts = Blog::blogPost(Blog::PUBLISHED,  (int) $_GET['page'] ?? 1);
            echo $this->getPostVar($posts, Blog::PUBLISHED);
            return;
        }

        if(isset($_GET['trash'])){
            if(Blog::trashPost((int) $_GET['trash'])):
                Flash::addMessage('You Trashed a Post', Flash::SUCCESS);
            else:
                Flash::addMessage('Unable to delete at the moment');
            endif;
            $this->redirect('/admin/post/all');
        }
        View::draw('{blog/all}', [
            '__is_admin' => true,
            '__post_stat' => $stat
        ]);
    }
    
    /**
     * Draft Page
     */
    public function draftAction()
    {
        // return;
        $statCount = Blog::postStat();
        
        $stat = [];
        foreach ($statCount['stat'] as $key) {
            $stat['__'.$key->status] = $key->count;
        }
        $stat['__all'] = $statCount['all']->total;
        // echo json_encode($stat);
        // return;
        
        if(isset($_GET['post'])){
            $posts = Blog::blogPost(Blog::DRAFT,  (int) $_GET['page'] ?? 1);
            echo $this->getPostVar($posts, Blog::DRAFT);
            return;
        }

        if(isset($_GET['trash'])){
            if(Blog::trashPost((int) $_GET['trash'])):
                Flash::addMessage('Draft Trashed', Flash::SUCCESS);
            else:
                Flash::addMessage('Unable to delete at the moment');
            endif;
            $this->redirect('/admin/post/all');
        }
        View::draw('{blog/all}', [
            '__is_admin' => true,
            '__post_stat' => $stat
        ]);
    }

    /**
     * Trash page
     */
    public function trashAction()
    {
        // return;
        $statCount = Blog::postStat();
        
        $stat = [];
        foreach ($statCount['stat'] as $key) {
            $stat['__'.$key->status] = $key->count;
        }
        $stat['__all'] = $statCount['all']->total;
        // echo json_encode($stat);
        // return;
        
        if(isset($_GET['post'])){
            $posts = Blog::blogPost(Blog::TRASH, (int) $_GET['page'] ?? 1);
            echo $this->getPostVar($posts, Blog::TRASH);
            return;
        }

        if(isset($_GET['delete'])){
            if(Blog::deletePost((int) $_GET['delete'])):
                Flash::addMessage('You Deleted a Post', Flash::SUCCESS);
            else:
                Flash::addMessage('Unable to Delete at the moment');
            endif;
            $this->redirect($_SERVER['REDIRECT_URL']);
        }
        if(isset($_GET['restore'])){
            if(Blog::restorePost((int) $_GET['restore'])):
                Flash::addMessage('You Restored a Post', Flash::SUCCESS);
            else:
                Flash::addMessage('Unable to Restore at the moment');
            endif;
            $this->redirect($_SERVER['REDIRECT_URL']);
        }
        View::draw('{blog/all}', [
            '__is_admin' => true,
            '__post_stat' => $stat
        ]);
    }

    /**
     * Categories Render Categories View,
     * Add new Category
     * Trash Category
     * @return void
     */
    public function categoriesAction()
    {
        // echo json_encode($_POST);
        if(isset($_POST['__name'])){
            if(Blog::saveCategory($_POST)):
                if($_POST['__type'] == 'save')
                    Flash::addMessage('Category successfully added', Flash::SUCCESS);
                    else
                    Flash::addMessage('Category successfully updated', Flash::SUCCESS);
            else:
                Flash::addMessage("Something Went wrong", Flash::WARNING);
                if($_POST['__type'] == 'update'){
                    $edit = $_GET['edit'] ?? '';
                    $this->redirect('/admin/post/categories?edit='.$edit);
                }

            endif;
            $this->redirect('/admin/post/categories');
        }

        $__editing_category = null;

        if(isset($_GET['edit'])){
            $__editing_category = Blog::categories($_GET);
        }

        if(isset($_GET['trash'])){
            if(Blog::trashCategory($_GET['trash'])):
                Flash::addMessage('You deleted a category', Flash::SUCCESS);
            else:
                Flash::addMessage('Unable to delete at the moment');
            endif;
            $this->redirect('/admin/post/categories');
        }

        View::draw('{blog/category}', [
            '__is_admin' => true,
            '__editing_category' => $__editing_category
        ]);
    }
    public function newCategoryAction()
    {
        View::draw('{blog/new}', [
            '__is_admin' => true
        ]);
    }
    public function commentAction()
    {
        View::draw('{blog/new}', [
            '__is_admin' => true
        ]);
    }
    public function tagAction()
    {
        // echo json_encode($_POST);
        if(isset($_POST['__name'])){
            if($bg = Blog::saveTag($_POST)):
                if($_POST['__type'] == 'save')
                    Flash::addMessage('Tag successfully added', Flash::SUCCESS);
                    else
                    Flash::addMessage('Tag successfully updated', Flash::SUCCESS);
            else:
                Flash::addMessage("Something Went wrong", Flash::WARNING);
                if($_POST['__type'] == 'update'){
                    $edit = $_GET['edit'] ?? '';
                    $this->redirect($_SERVER['REQUEST_URI']);
                }

            endif;
            $this->redirect($_SERVER['REDIRECT_URL']);
        }

        $__editing_tag = null;

        if(isset($_GET['edit'])){
            $__editing_tag = Blog::tags($_GET['edit']);
        }

        if(isset($_GET['trash'])){
            if($bg = Blog::trashTag($_GET['trash'])):
                // echo json_encode($bg);
                // return;
                Flash::addMessage('You deleted a tag', Flash::SUCCESS);
            else:
                Flash::addMessage('Unable to delete at the moment');
            endif;
            $this->redirect($_SERVER['REDIRECT_URL']);
        }

        View::draw('{blog/tag}', [
            '__is_admin' => true,
            '__editing_tag' => $__editing_tag
        ]);
    }

    public function filesAction()
    {
        echo json_encode(\App\Models\Site::__gallery());
    }

    public function getPostVar($post, $type = null)
    {
        $posts = $post;
        header('content-type: application/json');
        foreach ($posts as $key => $post) {
            $comment = Blog::getCommentCount($posts[$key]->post_id);
            $posts[$key]->comments = $comment;
            $date = 'Published '. date('Y/m/d', strtotime($posts[$key]->dtime)).' at '. date('H:i a', strtotime($posts[$key]->date));
            $posts[$key]->date = $date;


            $posts[$key]->author = Blog::getAuthor($posts[$key]->post_author);

            $category = Blog::postCategory($posts[$key]->category_id);
            $tag = Blog::postCategory($posts[$key]->post_tag, true);
            
            $categories = "";
            $tags = "";

            if(count($category) > 0):
                foreach ($category as $value):
                    $categories .= $value->category_name.', ';
                endforeach;
            endif;

            if(count($tag) > 0):
                foreach ($tag as $value):
                    if($value == '') continue; 
                    $tags .= ucwords($value->name).', ';
                endforeach;
            endif;
            $categories = preg_replace('/[^\d\w]+$/', '', $categories);
            $tags = preg_replace('/[^\d\w]+$/', '', $tags);

            $posts[$key]->category = $categories;
            $posts[$key]->tag = $tags;
        }

        $total = Blog::postStat($type)['all']->total;
        $limit = Blog::POST_LIMIT;
        $pages = round($total / $limit);

        return json_encode([
            'posts' => $posts,
            'pages' => $pages
        ]);
        // return;
    }

    /**
     * Bulk action
     * @return mixed
     */
    public function bulkAction()
    {
        return json_encode(Blog::bulkAction($_POST));
    }
}