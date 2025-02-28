output "cluster_name" {
  value = google_container_cluster.primary.name
}

output "cluster_location" {
  value = google_container_cluster.primary.location
}

output "cluster_endpoint" {
  value = google_container_cluster.primary.endpoint
}

output "db_instance_name" {
  value = google_sql_database_instance.nextgenmath_db_instance.name
}

output "db_connection_name" {
  value = google_sql_database_instance.nextgenmath_db_instance.connection_name
}
