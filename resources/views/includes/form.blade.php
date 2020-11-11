<section class="row">
    <div class="col s12">
        <form method="post" action="words/store" class="row">
            {{ csrf_field() }}
            <div class="col l4 m3 s12">
                <input placeholder="Long URL" type="url" name="url" required/>
            </div>
            <div class="col l4 m3 s12">
                <input placeholder="Short URL keyword" type="text" name="text" maxlength="140"/>
            </div>
            <label class="col l2 m3 s6">
                <input type="checkbox" name="private" value="1"/>
                <span>Private?</span>
            </label>
            <div class="col l2 m3 s6" >
                <button type="submit">Shorten</button>
            </div>
        </form>
    </div>
</section>
