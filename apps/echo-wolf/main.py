import sqlite3

def initialize_db():
    conn = sqlite3.connect("eidn-wolf.db")
    cursor = conn.cursor()

    cursor.execute("""
        CREATE TABLE IF NOT EXISTS messages (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	content TEXT
        )
    """)

    conn.commit()
    conn.close()

def save_message(text):
    conn = sqlite3.connect("eidn-wolf.db")
    cursor = conn.cursor()

    cursor.execute("INSERT INTO messages (content) VALUES (?)", (text,))

    conn.commit()
    conn.close()

def count_messages():
    conn = sqlite3.connect("eidn-wolf.db")
    cursor = conn.cursor()

    cursor.execute("SELECT COUNT(*) FROM messages")
    count = cursor.fetchone()[0]

    conn.close()
    return count

def run():
    print("The wires hum. The wolf leans forward.")

    initialize_db()

    while True:
        user_input = input("You: ")

        if user_input.lower() == "goodbye":
            print("The wolf dissolves back into the wires.")
            break

        if user_input.lower() == "help":
            print("Only you can help yourself.")


        save_message(user_input)

        total = count_messages()

        print(f"The wolf writes it down. '{user_input}' is recorded to the memory.")
        print(f"(Persistent memory size: {total})")

if __name__ == "__main__":
    run()
