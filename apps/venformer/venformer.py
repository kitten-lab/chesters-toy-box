from textual.app import App, ComposeResult
from textual.widgets import Header, Footer, Input, Static
from textual.containers import Vertical

class Venformer(App):

    CSS = """
    Screen {
        align: center middle;
    }

    #output {
        border: solid green;
        height: 10;
        padding: 1;
    }
    """

    def compose(self) -> ComposeResult:
        yield Header()
        yield Vertical(
            Static("Venformer ready. Describe what you want to create.", id="output"),
            Input(placeholder="Describe the ven you want...", id="input"),
        )
        yield Footer()

    def on_input_submitted(self, message: Input.Submitted) -> None:
        output = self.query_one("#output", Static)
        text = message.value
        output.update(f"Forming ven from: {text}")
        message.input.value = ""

if __name__ == "__main__":
    Venformer().run()