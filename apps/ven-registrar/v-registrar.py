#!/usr/bin/env python3
import json
import os
import sys
from datetime import datetime, timezone
import random
import string
from minter import *



DB_PATH = "ven_registry.json"

def load_db():
    if not os.path.exists(DB_PATH):
        return {"entries": []}
    with open(DB_PATH, "r", encoding="utf-8") as f:
        return json.load(f)

def save_db(db):
    with open(DB_PATH, "w", encoding="utf-8") as f:
        json.dump(db, f, indent=2)



def cmd_new():
    db = load_db()

    print("Creating new VEN\n")
    kven = input("ken: ").strip()
    label = input("label (private hint): ").strip()
    alts = input("alts (comma separated, in-world names): ").strip()
    matches = input("matches (variants in logs): ").strip()
    vtype = input("type (freeform, optional): ").strip()
    notes = input("notes: ").strip()

    entry = {
        "kven": kven,
        "label": label,
        "alts": [a.strip() for a in alts.split(",") if a.strip()],
        "matches": [m.strip() for m in matches.split(",") if m.strip()],
        "type": vtype,
        "notes": notes,
        "created": datetime.now(timezone.utc).isoformat()
    }

    db["entries"].append(entry)
    save_db(db)

    print("\nCreated VEN:")
    print("\nthis VEN has been seen before.")
    print(entry["kven"], entry["alts"])

def cmd_find(query):
    db = load_db()
    results = []

    for e in db["entries"]:
        haystack = " ".join([
            e.get("label",""),
            " ".join(e.get("alts", [])),
            " ".join(e.get("matches", []))
        ]).lower()

        if query.lower() in haystack:
            results.append(e)

    if not results:
        print("No matches.")
        return

    for e in results:
        print(f"\n[{e['kven']}] {', '.join(e.get('alts', []))}")
        print(f"label: {e.get('label')}")
        print(f"type: {e.get('type')}")
        print(f"matches: {', '.join(e.get('matches', []))}")

def cmd_list():
    db = load_db()
    for e in db["entries"]:
        print(f"{e['kven']} :: {', '.join(e.get('alts', []))}")

def cmd_view(kven):
    db = load_db()
    for e in db["entries"]:
        if e["kven"] == kven:
            print(json.dumps(e, indent=2))
            return
    print("Not found.")

def cmd_edit(kven):
    db = load_db()
    for e in db["entries"]:
        if e["kven"] == kven:
            print("Editing VEN (leave blank to keep current)\n")

            label = input(f"label [{e['label']}]: ").strip() or e["label"]
            alts = input(f"alts [{', '.join(e['alts'])}]: ").strip()
            matches = input(f"matches [{', '.join(e['matches'])}]: ").strip()
            vtype = input(f"type [{e['type']}]: ").strip() or e["type"]
            notes = input(f"notes [{e['notes']}]: ").strip() or e["notes"]

            if alts:
                e["alts"] = [a.strip() for a in alts.split(",") if a.strip()]
            if matches:
                e["matches"] = [m.strip() for m in matches.split(",") if m.strip()]

            e["label"] = label
            e["type"] = vtype
            e["notes"] = notes

            save_db(db)
            print("Updated.")
            return

    print("Not found.")

def repl():

    print(r"""
      ======================================================
      
           ___           ___                       ___      
          /  /\         /  /\                     /  /\     
         /  /::\       /  /::\         ___       /  /::|    
        /  /:/\:\     /__/:/\:\       /__/\     /  /:|:|    
       /  /::\ \:\    \  \:\ \:\      \__\:\   /  /:/|:|__  
      /__/:/\:\_\:\ ___\__\:\_\:\     /  /::\ /__/:/_|::::\ 
      \__\/  \:\/:/ \  \:::::\/:/  __/  /:/\/ \__\/  /~~/:/ 
           \__\::/   ~~~~\~~\::/  /__/\/:/~~        /  /:/  
           /  /:/        /~~/:/   \  \::/          /  /:/   
          /__/:/        /__/:/     \  \:\         /__/:/    
          \__\/         \__\/       \__\/         \__\/     

             ꓘ R A Q U A I 01 . 9808 . ɯᴉɹɐ ɐᴉpɯ
      ======================================================
                       VEN REGISTRY ONLINE
                                             ( hello, Sam. )
          """)
    print(" Remember! >| help for commands\n")
    while True:
        try:
            cmd = input(" >| ").strip()
        except (EOFError, KeyboardInterrupt):
            print("\nbye.")
            break

        if not cmd:
            continue

        parts = cmd.split()
        action = parts[0]

        if action == "end":
            break

        elif action == "help":
            print("commands:")
            print("  new")
            print("  find <query>")
            print("  list")
            print("  view <kven>")
            print("  edit <kven>")
            print("  exit")

        elif action == "new":
            cmd_new()

        elif action == "find":
            if len(parts) < 2:
                print("usage: find <query>")
            else:
                cmd_find(" ".join(parts[1:]))

        elif action == "list":
            cmd_list()

        elif action == "view":
            if len(parts) < 2:
                print("usage: view <kven>")
            else:
                cmd_view(parts[1])

        elif action == "edit":
            if len(parts) < 2:
                print("usage: edit <kven>")
            else:
                cmd_edit(parts[1])

        else:
            print("unknown command. type 'help'.")

def main():
    if len(sys.argv) == 1:
        repl()
        return

    # fallback to old CLI style if args are passed
    cmd = sys.argv[1]

    if cmd == "new":
        cmd_new()
    elif cmd == "find":
        cmd_find(" ".join(sys.argv[2:]))
    elif cmd == "list":
        cmd_list()
    elif cmd == "view":
        cmd_view(sys.argv[2])
    elif cmd == "edit":
        cmd_edit(sys.argv[2])

if __name__ == "__main__":
    main()