provider "google" {
  project     = "618479545522"
  region      = "us-west1"
  credentials = file("mathquix-95bee8a22869.json")
}

resource "google_container_cluster" "primary" {
  name               = "nextgenmath-cluster"
  location           = "us-west1-a"
  deletion_protection = false

  remove_default_node_pool = true

  initial_node_count = 1
}

resource "google_container_node_pool" "primary_nodes" {
  name       = "nextgenmath-node-pool"
  location   = google_container_cluster.primary.location
  cluster    = google_container_cluster.primary.name
  node_count = 1

  node_config {
    preemptible  = true
    machine_type = "e2-medium"
    oauth_scopes = [
      "https://www.googleapis.com/auth/cloud-platform"
    ]
  }
}

resource "google_sql_database_instance" "nextgenmath_db_instance" {
  name             = "nextgenmath-db-instance"
  database_version = "MYSQL_8_0"
  region           = "us-west1"

  settings {
    tier = "db-f1-micro"
    ip_configuration {
      ipv4_enabled = true
    }
  }
}

resource "google_sql_database" "nextgenmath_database" {
  name     = "nextgenmath"
  instance = google_sql_database_instance.nextgenmath_db_instance.name
}
