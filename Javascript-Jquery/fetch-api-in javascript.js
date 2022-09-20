<script>
    //API request 
    const apirequest = async () => {
        var res = await fetch('https://ppeh7sessj.execute-api.us-west-2.amazonaws.com/test/individual/get-recent-blogs?limit=3')
                    .then(response => response.json())
                    .then(({ data }) => embedProjects(data.blogs))
                    .catch(handleError);
    }
    apirequest()
    //Error handling 
    function handleError(error) {
        console.error(error);
    }
    function embedProjects(blogs) {
        console.log("Recent Blogs", blogs);
        //   Blog 1
        document.getElementById("blog-1-heading").innerText = blogs[0].name;
        document.getElementById("blog-1-paragraph").innerText = blogs[0].metaDescription;
        document.getElementById("blog-1-link").href = blogs[0].url
        document.getElementById("blog-1-image").setAttribute("src", blogs[0].featuredImage)
        //   Blog 2
        document.getElementById("blog-2-heading").innerText = blogs[1].name;
        document.getElementById("blog-2-paragraph").innerText = blogs[1].metaDescription;
        document.getElementById("blog-2-link").href = blogs[1].url
        document.getElementById("blog-2-image").setAttribute("src", blogs[1].featuredImage)
        //   Blog 3
        document.getElementById("blog-3-heading").innerText = blogs[2].name;
        document.getElementById("blog-3-paragraph").innerText = blogs[2].metaDescription;
        document.getElementById("blog-3-link").href = blogs[2].url
        document.getElementById("blog-3-image").setAttribute("src", blogs[2].featuredImage)
    }

</script>