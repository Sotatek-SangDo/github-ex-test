window.Echo
  .channel('fork-repository')
  .listen('.finished.fork', (e) => {
    const content = `Fork repo ${e.message} successfully`
    const alt = $('.alert-info')
    alt.html(content)
    alt.show();
    setTimeout(function() {
        alt.hide();
    }, 2000);
  });

