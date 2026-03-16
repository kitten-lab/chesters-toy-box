from textual.app import App, ComposeResult
from textual.containers import Vertical
from textual.widgets import Header, Footer, Input, Label, Select, Static

class Venformer(App):

    CSS = """
    Screen {
        align: center top;
        background: #0b0b0b;
    }

    #wrapper {
        width: 72;
        padding: 2;
        height: 1fr;
        overflow-y: auto;
    }

    .panel {
        border: round #6aff9c;
        padding: 1 2;
        margin: 1 0;
        height: 1fr;
        overflow-y: auto;
    }

    #title {
        text-align: center;
        color: #6aff9c;
        text-style: bold;
        margin-bottom: 1;
    }

    #preview {
        border: round #ffaa66;
        padding: 1 2;
        margin-top: 1;
        min-height: 8;
    }
    """

    TYPES = [
        ("Agent", "agent"),
        ("Creature", "creature"),
        ("Object", "object"),
        ("Structure", "structure"),
    ]

    def compose(self) -> ComposeResult:
        yield Header()

        yield Vertical(
            Label("VENFORMER // bootleg Mira creation console", id="title"),

            Vertical(
                Label("Common Fields"),
                Input(placeholder="Name", id="name"),
                Input(placeholder="Purpose", id="purpose"),
                Select(self.TYPES, prompt="Select ven type", id="ven_type"),
                classes="panel"
            ),

            Vertical(
                Label("Agent Options"),
                Input(placeholder="Temperament", id="agent_temperament"),
                Input(placeholder="Speech style", id="agent_speech"),
                id="agent_section",
                classes="panel"
            ),

            Vertical(
                Label("Creature Options"),
                Input(placeholder="Body style", id="creature_body"),
                Input(placeholder="Movement type", id="creature_move"),
                id="creature_section",
                classes="panel"
            ),

            Vertical(
                Label("Object Options"),
                Input(placeholder="Material", id="object_material"),
                Input(placeholder="Function", id="object_function"),
                id="object_section",
                classes="panel"
            ),

            Vertical(
                Label("Structure Options"),
                Input(placeholder="Scale", id="structure_scale"),
                Input(placeholder="Access method", id="structure_access"),
                id="structure_section",
                classes="panel"
            ),

            Static("Awaiting configuration...", id="preview"),

            id="wrapper"
        )

        yield Footer()

    def on_mount(self) -> None:
        self.hide_all_sections()

    def hide_all_sections(self):
        for section in [
            "#agent_section",
            "#creature_section",
            "#object_section",
            "#structure_section",
        ]:
            self.query_one(section).display = False

    def hide_all_sections(self):
        for section in [
            "#agent_section",
            "#creature_section",
            "#object_section",
            "#structure_section",
        ]:
            self.query_one(section).display = False

    def on_input_changed(self, event: Input.Changed):
        self.update_preview()

    def update_preview(self):
        name = self.query_one("#name", Input).value
        purpose = self.query_one("#purpose", Input).value
        ven_type = self.query_one("#ven_type", Select).value

        lines = [
            "VEN PREVIEW",
            f"Name: {name or '[unset]'}",
            f"Purpose: {purpose or '[unset]'}",
            f"Type: {ven_type or '[unset]'}"
        ]

        self.query_one("#preview", Static).update("\n".join(lines))


if __name__ == "__main__":
    Venformer().run()