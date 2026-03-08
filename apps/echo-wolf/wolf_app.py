from textual.app import App, ComposeResult
from textual.widgets import Header, Label, Placeholder
from textual.containers import Container, Horizontal, VerticalScroll, Center, HorizontalGroup, Grid, Right
class Box(Placeholder):
    """Example widget."""

    DEFAULT_CSS = """
    Box {
        width: 16;
        height: 5;        
    }
    """

class WolfApp(App):
    CSS = """
    Header {
        height: 3;
        background: darkgreen;
        color: white;
        border: solid green;
    }
    
    #game_header {
        row-span: 4;
        column-span: 8;
        height: 100%;
        background: red;
        border: ascii $accent;
    }
    #fugue_meter, #baseline_card, #focus_meter {
        row-span: 2;
        column-span: 6
    }

    Placeholder {
    }
    
    #top {
        width: 50%;
        grid-size: 2 2;

    }
    #bot {
        height: 50%;
        width: 100%;
        layout: grid;
        grid-size: 8 8;
    }
    """  

    def compose(self) -> ComposeResult:
        yield Header();
        with Center(classes="with-border"):  
            with HorizontalGroup(id="top"):
                yield Box("Fugue Round")
                yield Box("Baseline Card")
                yield Box("Focus Points")
            



    def on_mount(self) -> None:
        self.title = "Something Mattered Here"
        self.sub_title = "The Forgetting House"



    


if __name__ == "__main__":
    app = WolfApp()
    reply = app.run()
